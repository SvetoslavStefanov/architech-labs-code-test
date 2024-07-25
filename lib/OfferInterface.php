<?php

namespace lib;

use app\Basket;

interface OfferInterface {
  /**
   * Calculate the discount for the given products.
   *
   * @param Basket $basket
   * @return float
   */
  public function calculateDiscount(Basket $basket): float;
}
