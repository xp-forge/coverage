<?php namespace unittest\coverage\impl;

use PHPUnit\Runner\BaseTestRunner;
use SebastianBergmann\CodeCoverage\CodeCoverage;
use SebastianBergmann\CodeCoverage\Driver\Selector;

/** Coverage implementation for php-code-coverage >= 9.0 */
class Coverage9 extends Implementation {

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