<?php namespace unittest\coverage;

use SebastianBergmann\CodeCoverage\CodeCoverage;
use lang\Runtime;
use unittest\PrerequisitesNotMetError;
use unittest\TestResult;

/**
 * Coverage listener
 *
 * @ext   xdebug
 */
class CoverageListener implements \unittest\TestListener {
  private $paths= [];
  private $reportFile= 'coverage.html';
  private $coverage= null;

  /**
   * register a path to include in coverage report
   *
   * @param string
   */
  #[@arg]
  public function setRegisterPath($path) {
    $this->paths[]= $path;
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

    $this->coverage = new CodeCoverage;
  }

  /**
   * Called when a test case starts.
   *
   * @param   unittest.TestCase failure
   */
  public function testStarted(\unittest\TestCase $case) {
    // Empty
  }

  /**
   * Called when a test fails.
   *
   * @param   unittest.TestFailure failure
   */
  public function testFailed(\unittest\TestFailure $failure) {
    // Empty
  }

  /**
   * Called when a test errors.
   *
   * @param   unittest.TestFailure error
   */
  public function testError(\unittest\TestError $error) {
    // Empty
  }

  /**
   * Called when a test raises warnings.
   *
   * @param   unittest.TestWarning warning
   */
  public function testWarning(\unittest\TestWarning $warning) {
    // Empty
  }

  /**
   * Called when a test finished successfully.
   *
   * @param   unittest.TestSuccess success
   */
  public function testSucceeded(\unittest\TestSuccess $success) {
    // Empty
  }

  /**
   * Called when a test is not run because it is skipped due to a
   * failed prerequisite.
   *
   * @param   unittest.TestSkipped skipped
   */
  public function testSkipped(\unittest\TestSkipped $skipped) {
    // Empty
  }

  /**
   * Called when a test is not run because it has been ignored by using
   * the @ignore annotation.
   *
   * @param   unittest.TestSkipped ignore
   */
  public function testNotRun(\unittest\TestSkipped $ignore) {
    // Empty
  }

  /**
   * Called when a test run starts.
   *
   * @param   unittest.TestSuite suite
   */
  public function testRunStarted(\unittest\TestSuite $suite) {
    foreach ($this->paths as $path) {
      $this->coverage->filter()->addDirectoryToWhitelist($path);
    }

    $this->coverage->start('test');
  }

  /**
   * Called when a test run finishes.
   *
   * @param   unittest.TestSuite suite
   * @param   unittest.TestResult result
   */
  public function testRunFinished(\unittest\TestSuite $suite, TestResult $result) {
    $this->coverage->stop();

    $writer = new \SebastianBergmann\CodeCoverage\Report\Clover;
    $writer->process($this->coverage, './clover.xml');

    $writer = new \SebastianBergmann\CodeCoverage\Report\Html\Facade;
    $writer->process($this->coverage, './code-coverage-report');

    return;
  }
}