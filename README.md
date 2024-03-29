Code coverage for XP Framework unittests
========================================================================

[![Build status on GitHub](https://github.com/xp-forge/coverage/workflows/Tests/badge.svg)](https://github.com/xp-forge/coverage/actions)
[![XP Framework Module](https://raw.githubusercontent.com/xp-framework/web/master/static/xp-framework-badge.png)](https://github.com/xp-framework/core)
[![BSD Licence](https://raw.githubusercontent.com/xp-framework/web/master/static/licence-bsd.png)](https://github.com/xp-framework/core/blob/master/LICENCE.md)
[![Requires PHP 7.0+](https://raw.githubusercontent.com/xp-framework/web/master/static/php-7_0plus.svg)](http://php.net/)
[![Supports PHP 8.0+](https://raw.githubusercontent.com/xp-framework/web/master/static/php-8_0plus.svg)](http://php.net/)
[![Latest Stable Version](https://poser.pugx.org/xp-forge/coverage/version.png)](https://packagist.org/packages/xp-forge/coverage)

Code coverage for XP using XDebug. Based on Sebastian Bergmann's [Code coverage](https://github.com/sebastianbergmann/php-code-coverage) library.

Installation
------------

```bash
$ composer global require xp-forge/coverage
```

Next, make sure you have the [XDebug Zend extension](https://xdebug.org/download.php) loaded via `zend_extension`.

Usage
-----

```bash
$ xp coverage -p src/main/php/unittest/ src/test/php
[.....................]

♥: 21/21 run (0 skipped), 21 succeeded, 0 failed
Memory used: 3839.68 kB (4050.93 kB peak)
Time taken: 0.246 seconds
Coverage: 84.72% lines covered (61/72)

┌──────────────────────────────────────────────────────┬─────────┬──────┐
│ Class                                                │ % Lines │  Not │
╞══════════════════════════════════════════════════════╪═════════╪══════╡
│ unittest.coverage.ClassName                          │ 100.00% │      │
│ unittest.coverage.CoverageDetails                    │ 100.00% │      │
│ unittest.coverage.CoverageListener                   │  60.71% │   11 │
└──────────────────────────────────────────────────────┴─────────┴──────┘
```

### HTML Report

An optional HTML report can be generated like this. 

```bash
$ xp coverage -p src/main/php -r ./coverage-report src/test/php/
```

Use it in order to find out how to improve your coverage.

### Clover report

A [clover](https://www.atlassian.com/software/clover) report can be generated as well.

```bash
$ xp coverage -p src/main/php -c clover.xml src/test/php/
```
