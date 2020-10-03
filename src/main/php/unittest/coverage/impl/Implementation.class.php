<?php namespace unittest\coverage\impl;

interface Implementation {

  public function target($folder);

  public function targetsPresent();

  public function start($name);

  public function stop();

  public function report();
}