<?php

namespace lib;

/**
 * Interface ProductInterface
 * @package lib
 */
interface ProductInterface {
  public function getName(): string;
  public function getPrice(): float;
  public function getCode(): string;
}