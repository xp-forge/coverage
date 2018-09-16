<?php namespace unittest\coverage\tests;

use unittest\coverage\CoverageListener;
use unittest\{TestCase, TestSuite, TestResult};

class CoverageListenerTest extends TestCase {

  #[@test]
  public function can_create() {
    new CoverageListener();
  }

  #[@test]
  public function run() {
    $suite= new TestSuite();

    $l= new CoverageListener();
    $l->testRunStarted($suite);
    $l->testRunFinished($suite, new TestResult());
  }
}