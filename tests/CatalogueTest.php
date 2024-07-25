<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use app\Catalogue;
use app\Product;

class CatalogueTest extends TestCase {
  protected Catalogue $catalogue;

  protected function setUp(): void {
    $this->catalogue = new Catalogue();
  }

  public function testAddProduct(): void {
    $product = new Product('Red Widget', 32.95, 'R01');
    $this->catalogue->addProduct($product);

    $this->assertCount(1, $this->catalogue->getProducts());
    $this->assertSame($product, $this->catalogue->getProducts()['R01']);
  }

  public function testFindProductByCode(): void {
    $product = new Product('Red Widget', 32.95, 'R01');
    $this->catalogue->addProduct($product);

    $foundProduct = $this->catalogue->findProductByCode('R01');
    $this->assertSame($product, $foundProduct);
  }

  public function testFindProduct(): void {
    $product = new Product('Red Widget', 32.95, 'R01');
    $this->catalogue->addProduct($product);

    $foundProduct = $this->catalogue->findProduct($product);
    $this->assertSame($product, $foundProduct);
  }

  public function testGetProducts(): void {
    $product1 = new Product('Red Widget', 32.95, 'R01');
    $product2 = new Product('Green Widget', 24.95, 'G01');
    $this->catalogue->addProduct($product1);
    $this->catalogue->addProduct($product2);

    $products = $this->catalogue->getProducts();
    $this->assertCount(2, $products);
    $this->assertSame($product1, $products['R01']);
    $this->assertSame($product2, $products['G01']);
  }
}