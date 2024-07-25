<?php

namespace app;

use lib\OfferInterface;

/**
 * Buy one, get one half off
 * Works only when ordering two products of the same product code
 * It should work only for Red Widget (R01) by definition. Although it might work for other products as well.
 */
class BuyOneGetOneHalfOffer implements OfferInterface {
  private Basket $basket;
  /**
   * Calculate the discount for the given products from the Basket
   * The calculation has to be done this way:
   * If I have ordered 2 products with the same code - the second one is half price
   * If I have ordered 4 products with the same code - the second and fourth are half price
   * Same goes for 6 and so on.
   * Return the total price - the discount
   *
   * @param Basket $basket
   * @return float
   */
  public function calculateDiscount(Basket $basket): float {
    $this->basket = $basket;
    $discount = 0.0;
    $products = $basket->getProducts();
    $productCodes = array_count_values(array_map(fn($product) => $product->getCode(), $products));

    foreach ($productCodes as $code => $count) {
      if ($code !== 'R01') {
        continue;
      }
      $discount += $this->calculateDiscountForProduct($code, $count);
    }

    return $discount;
  }

  private function calculateDiscountForProduct(int|string $code, mixed $count): float|int {
    $discount = 0.0;
    $discountedCount = (int)($count / 2);
    $product = $this->basket->findProductByCode($code);

    if ($product) {
      $discount = $discountedCount * ($product->getPrice() / 2);
    }

    return $discount;
  }
}