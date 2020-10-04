<?php namespace unittest\coverage\tests;

use unittest\coverage\{CoverageListener, CoverageDetails};
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

    $this->assertInstanceOf(CoverageDetails::class, $result->metrics()['Coverage']);
  }

  #[Test]
  public function registering_path_fills_whitelist() {
    $c= new CoverageListener();
    $c->setRegisterPath('src/main/php');

    $this->assertTrue($c->coverage()->targetsPresent());
  }

  #[Test]
  public function html_export() {
    $c= new CoverageListener();
    $c->setHtmlReportDirectory('coverage-report');

    $this->assertTrue(array_key_exists('coverage-report/index.html', $c->exports()));
  }

  #[Test]
  public function clover_export() {
    $c= new CoverageListener();
    $c->setCloverFile('clover.xml');

    $this->assertTrue(array_key_exists('clover.xml', $c->exports()));
  }
}