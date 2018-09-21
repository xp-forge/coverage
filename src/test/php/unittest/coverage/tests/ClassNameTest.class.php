<?php namespace unittest\coverage\tests;

use unittest\TestCase;
use unittest\coverage\ClassName;

class ClassNameTest extends TestCase {

  #[@test]
  public function can_create() {
    new ClassName(self::class);
  }

  #[@test, @values([
  #  [38, 'unittest.coverage.tests.ClassNameTest'],
  #  [37, 'unittest.coverage.tests.ClassNameTest'],
  #  [36, '…ittest.coverage.tests.ClassNameTest'],
  #  [15, '….ClassNameTest'],
  #  [14, '…ClassNameTest'],
  #])]
  public function shortened($length, $expected) {
    $this->assertEquals($expected, (new ClassName(self::class))->shortenedTo($length));
  }

  #[@test]
  public function shortened_to_class_name() {
    $this->assertEquals('ClassNameTest', (new ClassName(self::class))->shortenedTo(13));
  }

  #[@test, @values([
  #  [12, '…assNameTest'],
  #  [2, '…t'],
  #  [1, '…'],
  #])]
  public function shortened_to_shorter_than_class_name($length, $expected) {
    $this->assertEquals($expected, (new ClassName(self::class))->shortenedTo($length));
  }
}