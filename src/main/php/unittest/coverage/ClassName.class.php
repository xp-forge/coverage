<?php namespace unittest\coverage;

class ClassName {
  private $name, $namespaces;

  /**
   * Creates a new class name
   *
   * @param  string $literal As used by PHP, with `\` as separator
   */
  public function __construct($literal) {
    $s= explode('\\', $literal);
    $this->name= array_pop($s);
    $this->namespaces= $s;
  }

  /**
   * Retrieves a shortened version of the class name, stripping namespaces
   * from the beginning.
   *
   * @param  int $max
   * @return string
   */
  public function shortenedTo($max) {
    $name= $this->name;

    $s= sizeof($this->namespaces);
    while ($s-- && strlen($name) < $max) {
      $name= $this->namespaces[$s].'.'.$name;
    }

    $l= strlen($name);
    if ($l > $max) {
      return '…'.substr($name, $l - $max + 1);
    } else {
      return $name;
    }
  }
}