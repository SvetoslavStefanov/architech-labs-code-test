<?php

namespace app;

/*
 * Find products by product code
 *
 */
class Catalogue {
  protected array $products = [];

  public function findProductByCode(string $code): ?Product {
    return $this->products[$code] ?? null;
  }

  public function findProduct(Product $product): ?Product {
    return $this->products[$product->getCode()] ?? null;
  }

  public function addProduct(Product $product): void {
    $this->products[$product->getCode()] = $product;
  }

  public function getProducts(): array {
    return $this->products;
  }
}