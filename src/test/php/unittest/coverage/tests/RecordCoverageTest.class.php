<?php namespace unittest\coverage\tests;

use unittest\actions\VerifyThat;
use unittest\coverage\RecordCoverage;
use unittest\{Test, Action, TestCase, TestResult, TestSuite};

#[Action(eval: 'new VerifyThat(function() { return interface_exists(\unittest\Listener::class); })')]
class RecordCoverageTest extends TestCase {

  #[Test]
  public function can_create() {
    new RecordCoverage();
  }

  #[Test]
  public function run_creates_metrics() {
    $suite= new TestSuite();
    $result= new TestResult();

    $l= new RecordCoverage();
    $l->testRunStarted($suite);
    $l->testRunFinished($suite, $result);

    $this->assertTrue(array_key_exists('Coverage', $result->metrics()));
  }

  #[Test]
  public function registering_path_fills_whitelist() {
    $c= new RecordCoverage();
    $c->setRegisterPath('src/main/php');

    $this->assertTrue($c->coverage()->targetsPresent());
  }

  #[Test]
  public function html_report() {
    $c= new RecordCoverage();
    $c->setHtmlReportDirectory('coverage-report');

    $this->assertTrue(array_key_exists('coverage-report/index.html', $c->reports()));
  }

  #[Test]
  public function clover_report() {
    $c= new RecordCoverage();
    $c->setCloverFile('clover.xml');

    $this->assertTrue(array_key_exists('clover.xml', $c->reports()));
  }
}