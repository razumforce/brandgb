<?php

require_once('autoload.php');

use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase {
  protected function setUp() {
    App::init();
  }
}

?>