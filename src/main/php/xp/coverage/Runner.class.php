<?php namespace xp\coverage;

use lang\reflect\TargetInvocationException;
use lang\{XPClass, Throwable};
use util\cmd\Console;

/**
 * Runs unittests, measures coverage and generates a report
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
 * - Same as above, additionally generate a HTML report
 *   ```sh
 *   $ xp coverage -p src/main/php -r ./coverage-report src/test/php
 *   ```
 *
 * The `-r` and `-c` options can be combined, of course.
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
      return XPClass::forName('xp.unittest.TestRunner')->getMethod('main')->invoke(null, [$pass]);
    } catch (TargetInvocationException $e) {
      Console::$err->writeLine($e->getCause());
      return 2;
    } catch (Throwable $e) {
      Console::$err->writeLine($e);
      return 1;
    }
  }
}