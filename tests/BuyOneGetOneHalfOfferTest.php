<?php

namespace tests;

use app\BuyOneGetOneHalfOffer;
use app\Basket;
use app\Catalogue;
use app\Product;
use PHPUnit\Framework\TestCase;

class BuyOneGetOneHalfOfferTest extends TestCase {
  protected Basket $basket;
  protected BuyOneGetOneHalfOffer $offer;
  protected Catalogue $catalogue;

  protected function setUp(): void {
    $this->catalogue = new Catalogue();
    $this->basket = new Basket($this->catalogue);
    $this->offer = new BuyOneGetOneHalfOffer();
  }

  private function addProductInCatalogueAndBasket(Product $product): void {
    $this->catalogue->addProduct($product);
    $this->basket->add($product);
  }

  public function testDiscountWithNoProducts(): void {
    $this->assertEquals(0.0, $this->offer->calculateDiscount($this->basket));
  }

  public function testDiscountWithOneProduct(): void {
    $this->addProductInCatalogueAndBasket(new Product('Red Widget', 32.95, 'R01'));
    $this->assertEquals(0.0, $this->offer->calculateDiscount($this->basket));
  }

  public function testDiscountWithTwoProductsSameCode(): void {
    $this->addProductInCatalogueAndBasket(new Product('Red Widget', 32.95, 'R01'));
    $this->addProductInCatalogueAndBasket(new Product('Red Widget', 32.95, 'R01'));

    $this->assertEquals(16.475, $this->offer->calculateDiscount($this->basket));
  }

  public function testDiscountWithTwoProductsDifferentCodes(): void {
    $this->addProductInCatalogueAndBasket(new Product('Red Widget', 32.95, 'R01'));
    $this->addProductInCatalogueAndBasket(new Product('Green Widget', 24.95, 'G01'));

    $this->assertEquals(0.0, $this->offer->calculateDiscount($this->basket));
  }

  public function testDiscountWithFourProductsSameCode(): void {
    $this->addProductInCatalogueAndBasket(new Product('Red Widget', 32.95, 'R01'));
    $this->addProductInCatalogueAndBasket(new Product('Red Widget', 32.95, 'R01'));
    $this->addProductInCatalogueAndBasket(new Product('Red Widget', 32.95, 'R01'));
    $this->addProductInCatalogueAndBasket(new Product('Red Widget', 32.95, 'R01'));

    $this->assertEquals(32.95, $this->offer->calculateDiscount($this->basket));
  }

  public function testDiscountWithMultipleSetsOfTwoProductsSameCode(): void {
    $this->addProductInCatalogueAndBasket(new Product('Red Widget', 32.95, 'R01'));
    $this->addProductInCatalogueAndBasket(new Product('Red Widget', 32.95, 'R01'));
    $this->addProductInCatalogueAndBasket(new Product('Red Widget', 32.95, 'R01'));
    $this->addProductInCatalogueAndBasket(new Product('Red Widget', 32.95, 'R01'));
    $this->addProductInCatalogueAndBasket(new Product('Red Widget', 32.95, 'R01'));
    $this->addProductInCatalogueAndBasket(new Product('Red Widget', 32.95, 'R01'));

    $this->assertEquals(49.425, round($this->offer->calculateDiscount($this->basket), 3));
  }
}