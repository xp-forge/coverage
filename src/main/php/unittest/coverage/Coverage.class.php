<?php namespace unittest\coverage;

use SebastianBergmann\CodeCoverage\Driver\Selector;
use lang\Throwable;
use unittest\PrerequisitesNotMetError;
use unittest\coverage\impl\{Coverage8, Coverage9};

/**
 * Factory class for coverage implementations
 */
abstract class Coverage {
  private static $impl;

  /** @codeCoverageIgnore */
  static function __static() {
    self::$impl= class_exists(Selector::class) ? Coverage9::class : Coverage8::class;
  }

  /**
   * Creates a new instance of the underlying implementation
   *
   * @return unittest.coverage.impl.Implementation
   */
  public static function newInstance() {
    try {
      return new self::$impl();
    } catch (\Throwable $e) {
      throw new PrerequisitesNotMetError(
        $e->getMessage().': Please install the xdebug or PHPdbg extensions',
        Throwable::wrap($e)
      );
    }
  }
}