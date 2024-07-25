<?php

namespace tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use lib\DeliveryCalculator;

class DeliveryCalculatorTest extends TestCase {
  use DeliveryCalculator;

  protected function setUp(): void {
    $this->deliveryRules = [];
  }

  public function testCalculateDeliveryWithNoRules(): void {
    $total = 100.0;
    $this->assertEquals(0.0, $this->calculateDelivery($total));
  }

  public function testCalculateDeliveryWithOneRule(): void {
    $this->addDeliveryRule(50, 4.95);
    $total = 40.0;
    $this->assertEquals(4.95, $this->calculateDelivery($total));
  }

  public function testCalculateDeliveryWithMultipleRules(): void {
    $this->addDeliveryRule(50, 4.95);
    $this->addDeliveryRule(90, 2.95);

    $total = 30.0;
    $this->assertEquals(4.95, $this->calculateDelivery($total));
    $total = 60.0;
    $this->assertEquals(2.95, $this->calculateDelivery($total));
    $total = 100.0;
    $this->assertEquals(0.0, $this->calculateDelivery($total));
  }

  public function testAddValidDeliveryRule(): void {
    $this->addDeliveryRule(50, 4.95);
    $this->assertCount(1, $this->deliveryRules);
    $this->assertEquals(['limit' => 50, 'cost' => 4.95], $this->deliveryRules[0]);
  }

  public function testAddInvalidDeliveryRule(): void {
    $this->expectException(InvalidArgumentException::class);
    $this->addDeliveryRule(0, -1.0);
  }
}