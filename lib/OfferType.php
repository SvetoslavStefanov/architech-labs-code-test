<?php

namespace lib;

use app\BuyOneGetOneHalfOffer;

enum OfferType: string {
  case BUY_ONE_GET_ONE_HALF = 'buy_one_get_one_half';

  public function handler(): OfferInterface {
    return match ($this) {
      self::BUY_ONE_GET_ONE_HALF => new BuyOneGetOneHalfOffer(),
    };
  }

  public function description(): string {
    return match ($this) {
      OfferType::BUY_ONE_GET_ONE_HALF => 'Buy one, get one half off',
    };
  }
}
