<?php

namespace app;

use lib\ProductInterface;

class Product implements ProductInterface {
  protected string $name;
  protected float $price;
  protected string $code;

  public function __construct(string $name, float $price, string $code) {
    $this->validateName($name);
    self::validatePrice($price);
    $this->validateCode($code);

    $this->name = $name;
    $this->price = $price;
    $this->code = $code;
  }


  public function getName(): string {
    return $this->name;
  }

  public function getPrice(): float {
    return $this->price;
  }

  public function getCode(): string {
    return $this->code;
  }

  private function validateCode(string $code): void {
    if (strlen($code) !== 3) {
      throw new \InvalidArgumentException('Product code must be 3 characters long');
    }
  }

  public static function validatePrice(mixed $price): void {
    if (!is_numeric($price)) {
      throw new \InvalidArgumentException('Price must be a number');
    }

    if ($price < 0) {
      throw new \InvalidArgumentException('Price must be a positive number');
    }
  }

  private function validateName(string $name): void {
    if (strlen($name) < 1) {
      throw new \InvalidArgumentException('Product name must be at least 1 character long');
    }
  }
}