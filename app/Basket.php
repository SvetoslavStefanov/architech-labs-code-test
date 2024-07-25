<?php

namespace app;

use InvalidArgumentException;
use lib\DeliveryCalculator;
use lib\OfferInterface;
use lib\OfferType;
use lib\ProductInterface;

/**
 * Represents a basket of products
 * $deliveryRules represents the delivery cost rules
 * $offers represents the offers applied
 * $products is an array of products in the basket
 */
class Basket {
  use DeliveryCalculator;

  /**
   * @var array<ProductInterface>
   */
  protected array $products = [];
  /**
   * @var array<array{limit: int, cost: float}>
   */
  protected array $deliveryRules = [];
  /**
   * @var array<OfferType>
   */
  protected array $offers = [];

  /**
   * Basket constructor
   * @param Catalogue $catalogue
   */
  public function __construct(protected Catalogue $catalogue) {
  }

  /**
   * Get the products in the basket
   * @return ProductInterface[]
   */
  public function getProducts(): array {
    return $this->products;
  }

  /**
   * Add an offer to the basket (that could be applied when the total is calculated)
   * @param OfferType|null $offerType
   */
  public function addOffer(?OfferType $offerType): void {
    if ($offerType === null) {
      throw new InvalidArgumentException("Offer type is null.");
    }
    /** @var OfferType|null $enumValue */
    $enumValue = OfferType::tryFrom($offerType->value);
    if ($enumValue === null) {
      throw new InvalidArgumentException("Offer type {$offerType->value} not found.");
    }

    $this->offers[] = $enumValue;
  }

  /**
   * Add a product to the basket, if already exist in the catalogue
   * @param ?ProductInterface $product
   * @throws InvalidArgumentException
   */
  public function add(?ProductInterface $product): void {
    if (!$product || !$this->catalogue->findProduct($product)){
      throw new InvalidArgumentException("Product code {$product?->getCode()} not found in the catalogue.");
    }

    $this->products[] = $product;
  }

  /**
   * Returns the total cost of the basket, taking into account the delivery and offer rules.
   * @return float
   */
  public function total(): float {
    $total = array_reduce($this->products, fn($sum, $product) => $sum + $product->getPrice(), 0);
    $total -= $this->applyOffers();
    $total += $this->calculateDelivery($total);

    return round($total, 3);
  }

  /**
   * Apply offers to the basket
   * @return float
   */
  private function applyOffers(): float {
    $discount = 0.0;

    foreach ($this->offers as $offerData) {
      $offer = $offerData->handler();
      /** @var OfferType $offerData */
      $discount += $offer->calculateDiscount($this);
      /** @var OfferInterface $offer */
    }

    return $discount;
  }

  /**
   * Find a product by product code
   * @param string $code
   * @return ProductInterface|null
   */
  public function findProductByCode(string $code): ?ProductInterface {
    $result = null;

    array_map(function($product) use ($code, &$result) {
      if ($product->getCode() === $code) {
        $result = $product;
      }
    }, $this->products);

    return $result;
  }
}