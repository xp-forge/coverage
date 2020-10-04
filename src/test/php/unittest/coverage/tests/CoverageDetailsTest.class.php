<?php namespace unittest\coverage\tests;

use unittest\coverage\CoverageDetails;
use unittest\coverage\impl\Report;
use unittest\{Test, TestCase, Values, Ignore};

class CoverageDetailsTest extends TestCase {

  #[Test]
  public function can_create() {
    new CoverageDetails(new Report(0, 0, []), []);
  }

  #[Test, Values([[0, 0, 0.0], [1, 2, 50.0], [2, 2, 100.0], [3, 2, 100.0]])]
  public function calculated($executed, $executable, $expected) {
    $report= new Report($executed, $executable, []);
    $this->assertEquals($expected, (new CoverageDetails($report, []))->calculated());
  }

  #[Test]
  public function formatted() {
    $report= new Report(100, 100, [
      'xp\coverage\Runner' => [
        'className' => 'xp\coverage\Runner',
        'methods'         => [
          'main' => [
            'methodName'      => 'main',
            'visibility'      => 'public',
            'signature'       => 'main(array $args)',
            'startLine'       => 30,
            'endLine'         => 74,
            'executableLines' => 29,
            'executedLines'   => 0,
            'ccn'             => 9,
            'coverage'        => 0,
            'crap'            => '90',
            'link'            => 'xp/coverage/Runner.class.php.html#30',
          ]
        ],
        'startLine'       => 27,
        'executableLines' => 29,
        'executedLines'   => 0,
        'ccn'             => 9,
        'coverage'        => 0,
        'crap'            => '90',
        'package'         => [
          'namespace'   => 'xp\coverage',
          'fullPackage' => '',
          'category'    => '',
          'package'     => '',
          'subpackage'  => '',
        ],
        'link' => "xp/coverage/Runner.class.php.html#27",
      ]
    ]);
    $this->assertNotEquals('', (new CoverageDetails($report, []))->formatted());
  }
}