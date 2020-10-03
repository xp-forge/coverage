<?php namespace unittest\coverage;

use unittest\metrics\Metric;

/**
 * Covered lines metric
 *
 * @test  xp://unittest.coverage.tests.CoverageDetailsTest
 */
class CoverageDetails extends Metric {
  private $coverage, $reports, $executed, $executable, $classes;

  /**
   * Creates a new detailled coverage instance
   *
   * @param  SebastianBergmann.CodeCoverage.Node.Directory $coverage
   * @param  string[] $reports
   */
  public function __construct($coverage, $reports) {
    $this->coverage= $coverage;
    $this->reports= $reports;
  }

  /** @return void */
  protected function calculate() {
    $this->executed= $this->coverage->getNumExecutedLines();
    $this->executable= $this->coverage->getNumExecutableLines();
    $this->classes= $this->coverage->getClasses();
  }

  /** @return string */
  protected function format() {

    // Summary
    $percent= $this->executed / $this->executable * 100;
    $s= sprintf(
      "%s%.2f%%\033[0m lines covered (%d/%d)%s\n\n",
      $percent < 50.0 ? "\033[31;1m" : ($percent < 90.0 ? "\033[33;1m" : "\033[32;1m"),
      $percent,
      $this->executed,
      $this->executable,
      $this->reports ? " > \033[36;4m".implode(' & ', $this->reports)."\033[0m" : ''
    );

    // Details by class
    $s.= "┌──────────────────────────────────────────────────────┬─────────┬──────┐\n";
    $s.= "│ Class                                                │ % Lines │  Not │\n";
    $s.= "╞══════════════════════════════════════════════════════╪═════════╪══════╡\n";
    foreach ($this->classes as $name => $details) {
      $percent= $details['coverage'];
      $color= $percent < 50.0 ? "\033[31;1m" : ($percent < 90.0 ? "\033[33;1m" : "\033[32;1m");
      $uncovered= $details['executableLines'] - $details['executedLines'];

      $s.= sprintf(
        "│ %-52s │ %s%6.2f%%\033[0m │ %4s │\n",
        (new ClassName($name))->shortenedTo(52),
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