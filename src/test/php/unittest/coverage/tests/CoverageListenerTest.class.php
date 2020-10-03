<?php namespace unittest\coverage\tests;

use unittest\coverage\CoverageListener;
use unittest\{Test, TestCase, TestResult, TestSuite};

/** @deprecated */
class CoverageListenerTest extends TestCase {

  #[Test]
  public function can_create() {
    new CoverageListener();
  }

  #[Test]
  public function run_creates_metrics() {
    $suite= new TestSuite();
    $result= new TestResult();

    $l= new CoverageListener();
    $l->testRunStarted($suite);
    $l->testRunFinished($suite, $result);

    $this->assertTrue(array_key_exists('Coverage', $result->metrics()));
  }

  #[Test]
  public function registering_path_fills_whitelist() {
    $c= new CoverageListener();
    $c->setRegisterPath('src/main/php');

    $this->assertFalse($c->coverage()->filter()->isEmpty());
  }

  #[Test]
  public function html_report() {
    $c= new CoverageListener();
    $c->setHtmlReportDirectory('coverage-report');

    $this->assertTrue(array_key_exists('coverage-report/index.html', $c->reports()));
  }

  #[Test]
  public function clover_report() {
    $c= new CoverageListener();
    $c->setCloverFile('clover.xml');

    $this->assertTrue(array_key_exists('clover.xml', $c->reports()));
  }
}