<?php namespace unittest\coverage\tests;

use unittest\coverage\ClassName;
use unittest\{Test, TestCase, Values};

class ClassNameTest extends TestCase {

  #[Test]
  public function can_create() {
    new ClassName(self::class);
  }

  #[Test, Values([[38, 'unittest.coverage.tests.ClassNameTest'], [37, 'unittest.coverage.tests.ClassNameTest'], [36, '…ittest.coverage.tests.ClassNameTest'], [15, '….ClassNameTest'], [14, '…ClassNameTest'],])]
  public function shortened($length, $expected) {
    $this->assertEquals($expected, (new ClassName(self::class))->shortenedTo($length));
  }

  #[Test]
  public function shortened_to_class_name() {
    $this->assertEquals('ClassNameTest', (new ClassName(self::class))->shortenedTo(13));
  }

  #[Test, Values([[12, '…assNameTest'], [2, '…t'], [1, '…'],])]
  public function shortened_to_shorter_than_class_name($length, $expected) {
    $this->assertEquals($expected, (new ClassName(self::class))->shortenedTo($length));
  }
}