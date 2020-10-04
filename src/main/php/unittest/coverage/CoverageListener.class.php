<?php namespace unittest\coverage;

use lang\Runtime;
use unittest\{
  Arg,
  PrerequisitesNotMetError,
  TestCase,
  TestSuite,
  TestListener,
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
 * @deprecated Used for xp-framework/unittest < 10.0.0
 * @ext   xdebug
 * @test  xp://unittest.coverage.tests.CoverageListenerTest
 */
class CoverageListener implements TestListener {
  private $coverage, $covering;
  private $exports= [];

  /** Register a path to include in coverage report */
  #[Arg]
  public function setRegisterPath(string $path) {
    $this->coverage->target($path);
  }

  /** Set directory to write html report to. */
  #[Arg]
  public function setHtmlReportDirectory(string $htmlReportDirectory) {
    $this->exports[$htmlReportDirectory.'/index.html']= function() use($htmlReportDirectory) {
      $this->coverage->writeHtml($htmlReportDirectory);
    };
  }

  /** Write clover report to specified file. */
  #[Arg]
  public function setCloverFile(string $cloverFile) {
    $this->exports[$cloverFile]= function() use($cloverFile) {
      $this->coverage->writeClover($cloverFile);
    };
  }

  /**
   * Constructor
   *
   * @param io.streams.OutputStreamWriter out
   */
  public function __construct() {
    if (!Runtime::getInstance()->extensionAvailable('xdebug')) {
      throw new PrerequisitesNotMetError('Code coverage not available. Please install the xdebug extension.');
    }

    $this->coverage= Coverage::newInstance();
  }

  /** @return SebastianBergmann.CodeCoverage.CodeCoverage */
  public function coverage() { return $this->coverage; }

  /** @return [:var] */
  public function exports() { return $this->exports; }

  /**
   * Called when a test case starts.
   *
   * @param   unittest.TestCase failure
   */
  public function testStarted(TestCase $case) {
    $this->covering && $this->coverage->stop();
    $this->coverage->start($case->getName(true));  // @codeCoverageIgnore
    $this->covering= true;
  }

  /**
   * Called when a test fails.
   *
   * @param   unittest.TestFailure failure
   */
  public function testFailed(TestFailure $failure) {
    // Empty
  }

  /**
   * Called when a test errors.
   *
   * @param   unittest.TestFailure error
   */
  public function testError(TestError $error) {
    // Empty
  }

  /**
   * Called when a test raises warnings.
   *
   * @param   unittest.TestWarning warning
   */
  public function testWarning(TestWarning $warning) {
    // Empty
  }

  /**
   * Called when a test finished successfully.
   *
   * @param   unittest.TestSuccess success
   */
  public function testSucceeded(TestSuccess $success) {
    // Empty
  }

  /**
   * Called when a test is not run because it is skipped due to a
   * failed prerequisite.
   *
   * @param   unittest.TestSkipped skipped
   */
  public function testSkipped(TestSkipped $skipped) {
    // Empty
  }

  /**
   * Called when a test is not run because it has been ignored by using
   * the @ignore annotation.
   *
   * @param   unittest.TestSkipped ignore
   */
  public function testNotRun(TestSkipped $ignore) {
    // Empty
  }

  /**
   * Called when a test run starts.
   *
   * @param   unittest.TestSuite suite
   */
  public function testRunStarted(TestSuite $suite) {
    $this->covering= false;
  }

  /**
   * Called when a test run finishes.
   *
   * @param   unittest.TestSuite suite
   * @param   unittest.TestResult result
   */
  public function testRunFinished(TestSuite $suite, TestResult $result) {
    $this->covering && $this->coverage->stop();

    foreach ($this->exports as $export) {
      $export();
    }

    $result->metric('Coverage', new CoverageDetails($this->coverage->report(), array_keys($this->exports)));
  }
}