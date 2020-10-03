<?php namespace unittest\coverage;

use SebastianBergmann\CodeCoverage\Driver\Selector;
use unittest\coverage\impl\{Coverage8, Coverage9};

/**
 * Factory class for coverage implementations
 */
abstract class Coverage {
  private static $impl;

  static function __static() {
    self::$impl= class_exists(Selector::class) ? Coverage9::class : Coverage8::class;
  }

  /** @return unittest.coverage.impl.Implementation */
  public static function newInstance() { return new self::$impl(); }
}