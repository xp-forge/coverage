<?php namespace unittest\coverage\impl;

use SebastianBergmann\CodeCoverage\{CodeCoverage, Filter};

class Coverage8 implements Implementation {
  private $filter, $backing;

  public function __construct() {
    $this->filter= new Filter();
    $this->backing= new CodeCoverage(null, $this->filter);
  }

  public function target($folder) {
    $this->filter->addDirectoryToWhitelist($folder);
  }

  public function targetsPresent() {
    return $this->filter->hasWhitelist();
  }

  public function start($name) {
    $this->backing->start($name);  // @codeCoverageIgnore
  }

  public function stop() {
    $this->backing->stop();
  }

  public function report() {
    $report= $this->backing->getReport();
    return new Report(
      $report->getNumExecutedLines(),
      $report->getNumExecutableLines(),
      $report->getClasses()
    );
  }
}