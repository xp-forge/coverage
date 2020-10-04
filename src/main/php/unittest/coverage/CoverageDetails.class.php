<?php namespace unittest\coverage;

use unittest\metrics\Metric;

/**
 * Covered lines metric
 *
 * @test  xp://unittest.coverage.tests.CoverageDetailsTest
 */
class CoverageDetails extends Metric {
  private $report, $exports;

  /**
   * Creates a new detailled coverage instance
   *
   * @param  unittest.coverage.impl.Report $report
   * @param  string[] $exports
   */
  public function __construct($report, $exports) {
    $this->report= $report;
    $this->exports= $exports;
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
      $this->exports ? " > \033[36;4m".implode(' & ', $this->exports)."\033[0m" : ''
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
    return $this->report->executed() / $this->report->executable() * 100;
  }
}