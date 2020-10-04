<?php namespace unittest\coverage\tests;

use lang\XPClass;
use unittest\coverage\Coverage;
use unittest\{Test, TestCase, Values, PrerequisitesNotMetError};

class CoverageTest extends TestCase {

  #[Test]
  public function can_create() {
    Coverage::newInstance();
  }

  #[Test]
  public function throws_exception_if_driver_is_missing() {
    $field= (new XPClass(Coverage::class))->getField('impl')->setAccessible(true);
    $impl= $field->get(null);

    $field->set(null, NonExistant::class);
    try {
      Coverage::newInstance();
      $this->fail('No exception raised', null, PrerequisitesNotMetError::class);
    } catch (PrerequisitesNotMetError $expected) {
      // OK
    } finally {
      $field->set(null, $impl);
    }
  }
}