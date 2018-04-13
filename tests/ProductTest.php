<?php

require_once('BaseTest.php');


class ProductTest extends BaseTest {

  public function testGetFeaturedProduct() {

    $this->assertNotNull(Product::featuredProduct());

  }
}