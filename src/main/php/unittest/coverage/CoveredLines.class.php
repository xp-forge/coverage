<?php namespace unittest\coverage;

use unittest\metrics\Metric;

/**
 * Covered lines metric
 *
 * @test  xp://unittest.coverage.tests.CoveredLinesTest
 */
class CoveredLines extends Metric {
  private $coverage, $executed, $executable;

  /** @param SebastianBergmann.CodeCoverage.CodeCoverage $coverage */
  public function __construct($coverage) {
    $this->coverage= $coverage;
  }

  /** @return void */
  protected function calculate() {
    $report= $this->coverage->getReport();
    $this->executed= $report->getNumExecutedLines();
    $this->executable= $report->getNumExecutableLines();
  }

  /** @return string */
  protected function format() {
    $percent= $this->executed / $this->executable * 100;
    return sprintf(
      "%s%.2f%%\033[0m lines covered (%d/%d)",
      $percent < 50.0 ? "\033[31;1m" : ($percent < 90.0 ? "\033[33;1m" : "\033[32;1m"),
      $percent,
      $this->executed,
      $this->executable
    );
  }

  /** @return var */
  protected function value() {
    return $this->executed / $this->executable * 100;
  }
}