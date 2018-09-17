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
$ xp coverage -p src/main/php src/test/php
[...........]

♥: 11/11 run (0 skipped), 11 succeeded, 0 failed
Memory used: 4347.41 kB (4622.48 kB peak)
Time taken: 0.434 seconds
Coverage: 66.67% lines covered (28/42)
```

Now open *./code-coverage-report/index.html* in your browser