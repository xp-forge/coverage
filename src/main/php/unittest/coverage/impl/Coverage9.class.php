<?php namespace unittest\coverage\impl;

use PHPUnit\Runner\BaseTestRunner;
use SebastianBergmann\CodeCoverage\CodeCoverage;
use SebastianBergmann\CodeCoverage\Driver\Selector;

/** Coverage implementation for php-code-coverage >= 9.0 */
class Coverage9 extends Implementation {

  static function __static() {

    // Workaround for fatal error in php-code-coverage when PHPUnit is not loaded
    // See https://github.com/sebastianbergmann/php-code-coverage/issues/820
    if (!class_exists(BaseTestRunner::class)) {
      eval('namespace PHPUnit\Runner; class BaseTestRunner {
        const STATUS_UNKNOWN    = -1;
        const STATUS_PASSED     = 0;
        const STATUS_SKIPPED    = 1;
        const STATUS_INCOMPLETE = 2;
        const STATUS_FAILURE    = 3;
        const STATUS_ERROR      = 4;
        const STATUS_RISKY      = 5;
        const STATUS_WARNING    = 6;
      }');
    }
  }

  /** Creates a new backing instance */
  protected function newInstance(): CodeCoverage {
    return new CodeCoverage((new Selector())->forLineCoverage($this->filter), $this->filter);
  }

  /**
   * Adds a folder as target
   *
   * @param  string $folder
   * @return void
   */
  public function target($folder) {
    $this->filter->includeDirectory($folder);
  }

  /**
   * Returns whether targets are present
   *
   * @return bool
   */
  public function targetsPresent() {
    return !$this->filter->isEmpty();
  }

  /** @return unittest.coverage.impl.Report */
  public function report() {
    $report= $this->backing->getReport();
    return new Report(
      $report->numberOfExecutedLines(),
      $report->numberOfExecutableLines(),
      $report->classes()
    );
  }
}