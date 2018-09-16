<?php namespace xp\coverage;

use lang\reflect\TargetInvocationException;
use lang\{XPClass, Throwable};
use util\cmd\Console;

/**
 * Runs unittests, measures coverage and displays a summary
 * ========================================================================
 *
 * - Runs tests in src/test/php, measuring coverage of src/main/php
 *   ```sh
 *   $ xp coverage -p src/main/php src/test/php
 *   ```
 * - Same as above, additionally generate a *clover.xml* file
 *   ```sh
 *   $ xp coverage -p src/main/php -c clover.xml src/test/php
 *   ```
 *
 * The HTML report is generated to *./code-coverage-report/index.html* by
 * default. The directory name can be changed by using the `-r` option.
 */
class Runner {

  /** @return int */
  public static function main(array $args) {

    // Generate arguments to `xp test`
    $pass= ['-l', 'unittest.coverage.CoverageListener', '-'];
    for ($i= 0, $s= sizeof($args); $i < $s; $i++) {
      if ('-p' === $args[$i]) {
        $pass[]= '-o';
        $pass[]= 'registerpath';
        $pass[]= $args[++$i];
      } else if ('-r' === $args[$i]) {
        $pass[]= '-o';
        $pass[]= 'htmlreportdirectory';
        $pass[]= $args[++$i];
      } else if ('-c' === $args[$i]) {
        $pass[]= '-o';
        $pass[]= 'cloverfile';
        $pass[]= $args[++$i];
      } else {
        $pass[]= $args[$i];
      }
    }

    try {
      XPClass::forName('xp.unittest.TestRunner')->getMethod('main')->invoke(null, [$pass]);
    } catch (TargetInvocationException $e) {
      Console::$err->writeLine($e->getCause());
      return 2;
    } catch (Throwable $e) {
      Console::$err->writeLine($e);
      return 1;
    }
  }
}