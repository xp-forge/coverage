<?php namespace unittest\coverage\impl;

use SebastianBergmann\CodeCoverage\Driver\Selector;
use SebastianBergmann\CodeCoverage\{CodeCoverage, Filter};

class Coverage9 implements Implementation {
  private $filter, $backing;

  public function __construct() {
    $this->filter= new Filter();
    $this->backing= new CodeCoverage((new Selector())->forLineCoverage($this->filter), $this->filter);
  }

  public function target($folder) {
    $this->filter->includeDirectory($folder);
  }

  public function targetsPresent() {
    return !$this->filter->isEmpty();
  }

  public function start($name) {
    $this->backing->start($name);  // @codeCoverageIgnore
  }

  public function stop() {
    $this->backing->stop();
  }

  public function report() {
    return $this->backing->getReport();
  }
}