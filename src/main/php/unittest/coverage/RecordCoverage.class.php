<?php namespace unittest\coverage;

use SebastianBergmann\CodeCoverage\Driver\Selector;
use SebastianBergmann\CodeCoverage\Report\Clover;
use SebastianBergmann\CodeCoverage\Report\Html\Facade;
use SebastianBergmann\CodeCoverage\{CodeCoverage, Filter};
use lang\Runtime;
use unittest\{
  Arg,
  PrerequisitesNotMetError,
  TestSuite,
  Listener,
  TestStart,
  TestResult,
  TestWarning,
  TestFailure,
  TestError,
  TestSkipped,
  TestSuccess
};

/**
 * Coverage listener
 *
 * @ext   xdebug
 * @test  xp://unittest.coverage.tests.CoverageListenerTest
 */
class RecordCoverage implements Listener {
  private $coverage, $covering, $filter;
  private $reports= [];

  /** Register a path to include in coverage report */
  #[Arg]
  public function setRegisterPath(string $path) {
    if (method_exists($this->filter, 'includeDirectory')) {
      $this->filter->includeDirectory($path);
    } else {
      $this->filter->addDirectoryToWhitelist($path);
    }
  }

  /** Set directory to write html report to. */
  #[Arg]
  public function setHtmlReportDirectory(string $htmlReportDirectory) {
    $this->reports[$htmlReportDirectory.'/index.html']= function($coverage) use($htmlReportDirectory) {
      (new Facade())->process($coverage, $htmlReportDirectory);
    };
  }

  /** Write clover report to specified file. */
  #[Arg]
  public function setCloverFile(string $cloverFile) {
    $this->reports[$cloverFile]= function($coverage) use($cloverFile) {
      (new Clover())->process($coverage, $cloverFile);
    };
  }

  /**
   * Constructor
   *
   * @param io.streams.OutputStreamWriter out
   */
  public function __construct() {
    if (!Runtime::getInstance()->extensionAvailable('xdebug')) {
      throw new PrerequisitesNotMetError('code coverage not available. Please install the xdebug extension.');
    }

    $this->filter= new Filter();
    $driver= class_exists(Selector::class) ? (new Selector())->forLineCoverage($this->filter) : null;
    $this->coverage= new CodeCoverage($driver, $this->filter);
  }

  /** @return SebastianBergmann.CodeCoverage.CodeCoverage */
  public function coverage() { return $this->coverage; }

  /** @return [:var] */
  public function reports() { return $this->reports; }

  /**
   * Called when a test case starts.
   *
   * @param  unittest.TestStart $start
   */
  public function testStarted(TestStart $start) {
    $this->covering && $this->coverage->stop();
    $this->coverage->start($start->test()->getName(true));  // @codeCoverageIgnore
    $this->covering= true;
  }

  /**
   * Called when a test fails.
   *
   * @param  unittest.TestFailure $failure
   */
  public function testFailed(TestFailure $failure) {
    // Empty
  }

  /**
   * Called when a test errors.
   *
   * @param  unittest.TestFailure $error
   */
  public function testError(TestError $error) {
    // Empty
  }

  /**
   * Called when a test raises warnings.
   *
   * @param  unittest.TestWarning $warning
   */
  public function testWarning(TestWarning $warning) {
    // Empty
  }

  /**
   * Called when a test finished successfully.
   *
   * @param  unittest.TestSuccess $success
   */
  public function testSucceeded(TestSuccess $success) {
    // Empty
  }

  /**
   * Called when a test is not run because it is skipped due to a
   * failed prerequisite.
   *
   * @param  unittest.TestSkipped $skipped
   */
  public function testSkipped(TestSkipped $skipped) {
    // Empty
  }

  /**
   * Called when a test is not run because it has been ignored by using
   * the @ignore annotation.
   *
   * @param  unittest.TestSkipped $ignore
   */
  public function testNotRun(TestSkipped $ignore) {
    // Empty
  }

  /**
   * Called when a test run starts.
   *
   * @param  unittest.TestSuite $suite
   */
  public function testRunStarted(TestSuite $suite) {
    $this->covering= false;
  }

  /**
   * Called when a test run finishes.
   *
   * @param  unittest.TestSuite $suite
   * @param  unittest.TestResult $result
   */
  public function testRunFinished(TestSuite $suite, TestResult $result) {
    $this->covering && $this->coverage->stop();

    foreach ($this->reports as $report) {
      $report($this->coverage);
    }

    $result->metric('Coverage', new CoverageDetails($this->coverage, array_keys($this->reports)));
  }
}