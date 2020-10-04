<?php namespace unittest\coverage;

use unittest\metrics\Metric;

/**
 * Covered lines metric
 *
 * @test  xp://unittest.coverage.tests.CoverageDetailsTest
 */
class CoverageDetails extends Metric {
  private $report, $reports;

  /**
   * Creates a new detailled coverage instance
   *
   * @param  unittest.coverage.impl.Report $report
   * @param  string[] $reports
   */
  public function __construct($report, $reports) {
    $this->report= $report;
    $this->reports= $reports;
  }

  /** @return void */
  protected function calculate() {
    /* NOOP */
  }

  /** @return string */
  protected function format() {

    // Summary
    $percent= $this->report->executed() / $this->report->executable() * 100;
    $s= sprintf(
      "%s%.2f%%\033[0m lines covered (%d/%d)%s\n\n",
      $percent < 50.0 ? "\033[31;1m" : ($percent < 90.0 ? "\033[33;1m" : "\033[32;1m"),
      $percent,
      $this->report->executed(),
      $this->report->executable(),
      $this->reports ? " > \033[36;4m".implode(' & ', $this->reports)."\033[0m" : ''
    );

    // Details by class
    $s.= "┌──────────────────────────────────────────────────────┬─────────┬──────┐\n";
    $s.= "│ Class                                                │ % Lines │  Not │\n";
    $s.= "╞══════════════════════════════════════════════════════╪═════════╪══════╡\n";
    foreach ($this->report->summary() as $class => $details) {
      $percent= $details['coverage'];
      $color= $percent < 50.0 ? "\033[31;1m" : ($percent < 90.0 ? "\033[33;1m" : "\033[32;1m");
      $uncovered= $details['executableLines'] - $details['executedLines'];

      $s.= sprintf(
        "│ %-52s │ %s%6.2f%%\033[0m │ %4s │\n",
        (new ClassName($class))->shortenedTo(52),
        $color,
        $percent,
        $uncovered ?: ''
      );
    }

    $s.= "└──────────────────────────────────────────────────────┴─────────┴──────┘";
    return $s;
  }

  /** @return var */
  protected function value() {
    return $this->executed / $this->executable * 100;
  }
}