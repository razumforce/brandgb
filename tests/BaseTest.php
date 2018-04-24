<?php

require_once('autoload2.php');

use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase {
  protected function setUp() {
    App::init();
  }
}

?>