<?php namespace unittest\coverage\tests;

use unittest\coverage\CoverageListener;
use unittest\{TestCase, TestSuite, TestResult};

class CoverageListenerTest extends TestCase {

  #[@test]
  public function can_create() {
    new CoverageListener();
  }

  #[@test]
  public function run_creates_metrics() {
    $suite= new TestSuite();
    $result= new TestResult();

    $l= new CoverageListener();
    $l->testRunStarted($suite);
    $l->testRunFinished($suite, $result);

    $this->assertTrue(array_key_exists('Coverage', $result->metrics()));
  }
}