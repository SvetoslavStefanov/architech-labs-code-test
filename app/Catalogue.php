<?php

namespace app;

use lib\ProductInterface;

class Catalogue {
  protected array $products = [];

  /**
   * Find a product by its code
   * @param string $code
   * @return ProductInterface|null
   */
  public function findProductByCode(string $code): ?ProductInterface {
    return $this->products[$code] ?? null;
  }

  /**
   * Find if a product is in the catalogue
   * @param ProductInterface $product
   * @return ProductInterface|null
   */
  public function findProduct(ProductInterface $product): ?ProductInterface {
    return $this->products[$product->getCode()] ?? null;
  }

  /**
   * Add a product to the catalogue
   * @param ProductInterface $product
   */
  public function addProduct(ProductInterface $product): void {
    $this->products[$product->getCode()] = $product;
  }

  /**
   * Get all products in the catalogue
   * @return ProductInterface[]
   */
  public function getProducts(): array {
    return $this->products;
  }
}