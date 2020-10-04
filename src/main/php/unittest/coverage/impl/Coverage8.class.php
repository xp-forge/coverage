<?php namespace unittest\coverage\impl;

use SebastianBergmann\CodeCoverage\Report\Clover;
use SebastianBergmann\CodeCoverage\Report\Html\Facade;
use SebastianBergmann\CodeCoverage\{CodeCoverage, Filter};

class Coverage8 implements Implementation {
  private $filter, $backing;

  /** Creates a new coverage implementation for php-code-coverage < 9.0 */
  public function __construct() {
    $this->filter= new Filter();
    $this->backing= new CodeCoverage(null, $this->filter);
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

  /**
   * Starts coverage
   *
   * @param  string $name
   * @return void
   */
  public function start($name) {
    $this->backing->start($name);
  }

  /**
   * Stops coverage
   *
   * @return void
   */
  public function stop() {
    $this->backing->stop();
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

  /**
   * Writes HTML
   *
   * @param  string $folder
   * @return void
   */
  public function writeHtml($folder) {
    (new Facade())->process($this->backing, $folder);
  }

  /**
   * Writes Clover file
   *
   * @param  string $file
   * @return void
   */
  public function writeClover($file) {
    (new Clover())->process($this->backing, $file);
  }
}