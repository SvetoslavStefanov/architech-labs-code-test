<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use app\BuyFourGetFifthFreeOffer;
use app\Basket;
use app\Catalogue;
use app\Product;

class BuyFourGetFifthFreeOfferTest extends TestCase {
  protected Basket $basket;
  protected BuyFourGetFifthFreeOffer $offer;
  protected Catalogue $catalogue;

  protected function setUp(): void {
    $this->catalogue = new Catalogue();
    for ($i = 1; $i <= 5; $i++) {
      $this->catalogue->addProduct(new Product("Product $i", 10.0 * $i, "P0$i"));
    }

    $this->basket = new Basket($this->catalogue);
    $this->offer = new BuyFourGetFifthFreeOffer();
  }

  public function testDiscountWithNoProducts(): void {
    $this->assertEquals(0.0, $this->offer->calculateDiscount($this->basket));
  }

  public function testDiscountWithFewerThanFiveProducts(): void {
    $maxCounter = 4;
    foreach ($this->catalogue->getProducts() as $product) {
      if ($maxCounter-- === 0) {
        break;
      }
      $this->basket->add($product);
    }

    $this->assertEquals(0.0, $this->offer->calculateDiscount($this->basket));
  }

  public function testDiscountWithExactlyFiveProducts(): void {
    foreach ($this->catalogue->getProducts() as $product) {
      $this->basket->add($product);
    }

    $this->assertEquals(10.0, $this->offer->calculateDiscount($this->basket));
  }

  public function testDiscountWithMoreThanFiveProducts(): void {
    $this->catalogue->addProduct(new Product('Product 5', 60.0, 'P06'));
    foreach ($this->catalogue->getProducts() as $product) {
      $this->basket->add($product);
    }

    $this->assertEquals(10.0, $this->offer->calculateDiscount($this->basket));
  }

  public function testDiscountWithMultipleSetsOfFiveProducts(): void {
    for ($i = 0; $i <= 9; $i++) {
      if (!$this->catalogue->findProductByCode("P0$i")) {
        $this->catalogue->addProduct(new Product("Product $i", 10.0 * ($i + 1), "P0$i"));
      }

      $this->basket->add($this->catalogue->findProductByCode("P0$i"));
    }

    $this->assertEquals(20.0, $this->offer->calculateDiscount($this->basket));
  }
}