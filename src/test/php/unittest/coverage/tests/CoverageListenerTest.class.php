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

  #[@test]
  public function registering_path_fills_whitelist() {
    $c= new CoverageListener();
    $c->setRegisterPath('src/main/php');

    $this->assertTrue($c->coverage()->filter()->hasWhitelist());
  }

  #[@test]
  public function html_report() {
    $c= new CoverageListener();
    $c->setHtmlReportDirectory('coverage-report');

    $this->assertTrue(array_key_exists('coverage-report/index.html',$c->reports()));
  }

  #[@test]
  public function clover_report() {
    $c= new CoverageListener();
    $c->setCloverFile('clover.xml');

    $this->assertTrue(array_key_exists('clover.xml', $c->reports()));
  }
}