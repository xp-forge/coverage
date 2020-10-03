<?php namespace unittest\coverage\tests;

use SebastianBergmann\CodeCoverage\CodeCoverage;
use unittest\coverage\CoverageDetails;
use unittest\{Test, TestCase, Values};

class CoverageDetailsTest extends TestCase {

  #[Test]
  public function can_create() {
    new CoverageDetails(new CodeCoverage(), []);
  }

  #[Test, Values([[[1 => []], 0.0], [[1 => ['test']], 100.0], [[1 => [], 2 => ['test']], 50.0], [[1 => [], 2 => ['test'], 3 => null], 50.0],])]
  public function calculated($lines, $expected) {
    $coverage= new CodeCoverage();
    $coverage->setData([__FILE__ => $lines]);

    $this->assertEquals($expected, (float)(new CoverageDetails($coverage, []))->calculated());
  }

  #[Test]
  public function formatted() {
    $coverage= new CodeCoverage();
    $coverage->setData([__FILE__ => [1 => ['test']]]);

    $this->assertNotEquals('', (new CoverageDetails($coverage, []))->formatted());
  }
}