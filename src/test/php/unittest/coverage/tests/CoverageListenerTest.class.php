<?php namespace unittest\coverage\tests;

use unittest\TestCase;
use unittest\coverage\CoverageListener;

class CoverageListenerTest extends TestCase {

  #[@test]
  public function can_create() {
    new CoverageListener();
  }
}