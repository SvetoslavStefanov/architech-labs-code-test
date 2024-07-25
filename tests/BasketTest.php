<?php
namespace tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use app\Basket;
use app\Catalogue;
use app\Product;
use lib\OfferType;

class BasketTest extends TestCase {
  protected Basket $basket;
  protected Catalogue $catalogue;

  protected function setUp(): void {
    $this->catalogue = new Catalogue();
    $this->basket = new Basket($this->catalogue);

    $this->catalogue->addProduct(new Product('Red Widget', 32.95, 'R01'));
    $this->catalogue->addProduct(new Product('Green Widget', 24.95, 'G01'));
    $this->catalogue->addProduct(new Product('Blue Widget', 7.95, 'B01'));
  }

  public function testAddProductToBasket(): void {
    $product = $this->catalogue->findProductByCode('R01');
    $this->basket->add($product);

    $this->assertCount(1, $this->basket->getProducts());
    $this->assertSame($product, $this->catalogue->getProducts()['R01']);
  }

  public function testTotalCostWithoutOffers(): void {
    $this->basket->add($this->catalogue->findProductByCode('R01'));
    $this->basket->add($this->catalogue->findProductByCode('G01'));

    $this->assertEquals(57.90, $this->basket->total());
  }

  public function testTotalCostWithOffers(): void {
    $this->basket->add($this->catalogue->findProductByCode('R01'));
    $this->basket->add($this->catalogue->findProductByCode('R01'));
    $this->basket->addOffer(OfferType::BUY_ONE_GET_ONE_HALF);

    $this->assertEquals(49.425, $this->basket->total());
  }

  public function testTotalCostWithOffersAndDelivery(): void {
    $this->basket->add($this->catalogue->findProductByCode('R01'));
    $this->basket->add($this->catalogue->findProductByCode('R01'));
    $this->basket->addOffer(OfferType::BUY_ONE_GET_ONE_HALF);
    $this->basket->addDeliveryRule(50, 4.95);
    $this->basket->addDeliveryRule(90, 2.95);

    $this->assertEquals(54.375, $this->basket->total());
  }

  public function testInvalidProductCode(): void {
    $this->expectException(InvalidArgumentException::class);
    $this->basket->add($this->catalogue->findProductByCode('INVALID_CODE'));
  }
}