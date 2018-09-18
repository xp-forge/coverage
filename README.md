Code coverage for XP Framework unittests
========================================================================

[![Build Status on TravisCI](https://secure.travis-ci.org/xp-forge/coverage.png)](http://travis-ci.org/xp-forge/coverage)
[![XP Framework Module](https://raw.githubusercontent.com/xp-framework/web/master/static/xp-framework-badge.png)](https://github.com/xp-framework/core)
[![BSD Licence](https://raw.githubusercontent.com/xp-framework/web/master/static/licence-bsd.png)](https://github.com/xp-framework/core/blob/master/LICENCE.md)
[![Supports PHP 7.0+](https://raw.githubusercontent.com/xp-framework/web/master/static/php-7_0plus.png)](http://php.net/)
[![Latest Stable Version](https://poser.pugx.org/xp-forge/coverage/version.png)](https://packagist.org/packages/xp-forge/coverage)

Code coverage for XP using the [XDebug Zend extension](https://xdebug.org/download.php). Based on Sebastian Bergmann's [Code coverage](https://github.com/sebastianbergmann/php-code-coverage) library.

Usage
-----

```bash
$ xp coverage -p src/main/php/unittest/ src/test/php
[.................]

♥: 13/13 run (0 skipped), 13 succeeded, 0 failed
Memory used: 5026.80 kB (5307.88 kB peak)
Time taken: 0.423 seconds
Coverage: 79.01% lines covered (64/81)

┌──────────────────────────────────────────────────────┬─────────┬──────┐
│ Class                                                │ % Lines │  Not │
╞══════════════════════════════════════════════════════╪═════════╪══════╡
│ unittest.coverage.CoverageDetails                    │  97.37% │    1 │
│ unittest.coverage.CoverageListener                   │  44.83% │   16 │
│ unittest.coverage.CoveredLines                       │ 100.00% │      │
└──────────────────────────────────────────────────────┴─────────┴──────┘
```

