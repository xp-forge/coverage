<?php namespace unittest\coverage\tests;

use SebastianBergmann\CodeCoverage\CodeCoverage;
use unittest\TestCase;
use unittest\coverage\CoveredLines;

class CoveredLinesTest extends TestCase {

  #[@test]
  public function can_create() {
    new CoveredLines(new CodeCoverage());
  }

  #[@test, @values([
  #  [[1 => []], 0.0],
  #  [[1 => ['test']], 100.0],
  #  [[1 => [], 2 => ['test']], 50.0],
  #  [[1 => [], 2 => ['test'], 3 => null], 50.0],
  #])]
  public function calculated($lines, $expected) {
    $coverage= new CodeCoverage();
    $coverage->setData([__FILE__ => $lines]);

    $this->assertEquals($expected, (float)(new CoveredLines($coverage))->calculated());
  }

  #[@test, @values([
  #  [[1 => []], '0.00% lines covered (0/1)'],
  #  [[1 => ['test']], '100.00% lines covered (1/1)'],
  #  [[1 => [], 2 => ['test']], '50.00% lines covered (1/2)'],
  #  [[1 => [], 2 => ['test'], 3 => null], '50.00% lines covered (1/2)'],
  #])]
  public function formatted($lines, $expected) {
    $coverage= new CodeCoverage();
    $coverage->setData([__FILE__ => $lines]);

    $this->assertEquals($expected, preg_replace('/\033.+m/U', '', (new CoveredLines($coverage))->formatted()));
  }
}