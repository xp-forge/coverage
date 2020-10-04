<?php namespace unittest\coverage\impl;

class Report {
  private $executed, $executable, $summary;

  /**
   * Creates a new report
   *
   * @param  int $executed
   * @param  int $executable
   * @param  [:var] $summary Details, keyed by class name
   */
  public function __construct($executed, $executable, $summary) {
    $this->executed= $executed;
    $this->executable= $executable;
    $this->summary= $summary;
  }

  /** @return int */
  public function executed() { return $this->executed; }

  /** @return int */
  public function executable() { return $this->executable; }

  /** @return [:var] */
  public function summary() { return $this->summary; }
}