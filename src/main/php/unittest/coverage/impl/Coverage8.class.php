<?php namespace unittest\coverage\impl;

use SebastianBergmann\CodeCoverage\CodeCoverage;

/** Coverage implementation for php-code-coverage < 9.0 */
class Coverage8 extends Implementation {

  /** Creates a new backing instance */
  protected function newInstance(): CodeCoverage {
    return new CodeCoverage(null, $this->filter);
  }

  /**
   * Adds a folder as target
   *
   * @param  string $folder
   * @return void
   */
  public function target($folder) {
    $this->filter->addDirectoryToWhitelist($folder);
  }

  /**
   * Returns whether targets are present
   *
   * @return bool
   */
  public function targetsPresent() {
    return $this->filter->hasWhitelist();
  }

  /** @return unittest.coverage.impl.Report */
  public function report() {
    $report= $this->backing->getReport();
    return new Report(
      $report->getNumExecutedLines(),
      $report->getNumExecutableLines(),
      $report->getClasses()
    );
  }
}