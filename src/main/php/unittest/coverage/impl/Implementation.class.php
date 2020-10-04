<?php namespace unittest\coverage\impl;

use SebastianBergmann\CodeCoverage\Report\Clover;
use SebastianBergmann\CodeCoverage\Report\Html\Facade;
use SebastianBergmann\CodeCoverage\{CodeCoverage, Filter};

abstract class Implementation {
  protected $filter, $backing;

  /** Creates a new coverage implementation for php-code-coverage < 9.0 */
  public function __construct() {
    $this->filter= new Filter();
    $this->backing= $this->newInstance();
  }

  /** Creates a new backing instance */
  protected abstract function newInstance(): CodeCoverage;

  /**
   * Adds a folder as target
   *
   * @param  string $folder
   * @return void
   */
  public abstract function target($folder);

  /**
   * Returns whether targets are present
   *
   * @return bool
   */
  public abstract function targetsPresent();

  /**
   * Starts coverage
   *
   * @param  string $name
   * @return void
   */
  public function start($name) {
    $this->backing->start($name); // @codeCoverageIgnore
  }

  /**
   * Stops coverage
   *
   * @return void
   */
  public function stop() {
    $this->backing->stop();
  }

  /**
   * Returns the compiled coverage report
   *
   * @return unittest.coverage.impl.Report
   */
  public abstract function report();

  /**
   * Writes HTML
   *
   * @param  string $folder
   * @return void
   */
  public function writeHtml($folder) {
    (new Facade())->process($this->backing, $folder);
  }

  /**
   * Writes Clover file
   *
   * @param  string $file
   * @return void
   */
  public function writeClover($file) {
    (new Clover())->process($this->backing, $file);
  }
}