<?php

namespace lib;

use app\BuyFourGetFifthFreeOffer;
use app\BuyOneGetOneHalfOffer;

enum OfferType: string {
  case BUY_ONE_GET_ONE_HALF = 'buy_one_get_one_half';
  case BUY_FOUR_GET_FIFTH_FREE = 'buy_four_get_fifth_free';

  public function handler(): OfferInterface {
    return match ($this) {
      self::BUY_ONE_GET_ONE_HALF => new BuyOneGetOneHalfOffer(),
      self::BUY_FOUR_GET_FIFTH_FREE => new BuyFourGetFifthFreeOffer(),
    };
  }

  public function description(): string {
    return match ($this) {
      OfferType::BUY_ONE_GET_ONE_HALF => 'Buy one, get one half off',
      OfferType::BUY_FOUR_GET_FIFTH_FREE => 'Buy four, get fifth free',
    };
  }
}
