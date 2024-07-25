<?php

namespace app;

use lib\OfferInterface;

class BuyFourGetFifthFreeOffer implements OfferInterface {
  public function calculateDiscount(Basket $basket): float {
    $discount = 0.0;
    $products = $basket->getProducts();

    // Sort products by price in ascending order
    usort($products, fn($a, $b) => $a->getPrice() <=> $b->getPrice());

    // Calculate the number of free items
    $freeItemsCount = intdiv(count($products), 5);

    // Sum the prices of the cheapest items to be free
    for ($i = 0; $i < $freeItemsCount; $i++) {
      $discount += $products[$i]->getPrice();
    }

    return $discount;
  }
}