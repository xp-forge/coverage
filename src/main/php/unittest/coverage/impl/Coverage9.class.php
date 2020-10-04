<?php namespace unittest\coverage\impl;

use SebastianBergmann\CodeCoverage\Driver\Selector;
use SebastianBergmann\CodeCoverage\{CodeCoverage, Filter};

class Coverage9 implements Implementation {
  private $filter, $backing;

  /** Creates a new coverage implementation for php-code-coverage >= 9.0 */
  public function __construct() {
    $this->filter= new Filter();
    $this->backing= new CodeCoverage((new Selector())->forLineCoverage($this->filter), $this->filter);
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

  /**
   * Starts coverage
   *
   * @param  string $name
   * @return void
   */
  public function start($name) {
    $this->backing->start($name);  // @codeCoverageIgnore
  }

  /**
   * Stops coverage
   *
   * @return void
   */
  public function stop() {
    $this->backing->stop();
  }

  /** @return unittest.coerage.impl.Report */
  public function report() {
    $report= $this->backing->getReport();
    return new Report(
      $report->numberOfExecutedLines(),
      $report->numberOfExecutableLines(),
      $report->classes()
    );
  }
}