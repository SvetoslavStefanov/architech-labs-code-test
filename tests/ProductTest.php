<?php

namespace tests;

use app\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase {
  public function testProductNameIsSetCorrectly(): void {
    $product = new Product('Red Widget', '32.95', 'R01');
    $this->assertEquals('Red Widget', $product->getName());
  }

  public function testProductPriceIsSetCorrectly(): void {
    $product = new Product('Red Widget', '32.95', 'R01');
    $this->assertEquals(32.95, $product->getPrice());
  }

  public function testProductCodeIsSetCorrectly(): void {
    $product = new Product('Red Widget', '32.95', 'R01');
    $this->assertEquals('R01', $product->getCode());
  }

  public function testProductCodeMustBeThreeCharacters(): void {
    $this->expectException(\InvalidArgumentException::class);
    new Product('Red Widget', '32.95', 'R001');
  }

  public function testProductPriceMustBePositive(): void {
    $this->expectException(\InvalidArgumentException::class);
    new Product('Red Widget', '-32.95', 'R01');
  }

  public function testProductPriceMustBeNumeric(): void {
    $this->expectException(\InvalidArgumentException::class);
    new Product('Red Widget', 'thirty-two', 'R01');
  }

  public function testProductNameMustBeAtLeastOneCharacter(): void {
    $this->expectException(\InvalidArgumentException::class);
    new Product('', '32.95', 'R01');
  }
}