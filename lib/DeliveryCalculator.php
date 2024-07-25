<?php

namespace lib;

trait DeliveryCalculator {
  /**
   * Calculate the delivery cost based on the total price
   * We assume that if there are no rules, the delivery is 0 (free) and that after the last rule, the delivery is also 0 (free)
   * @param float $total
   * @return float The delivery cost for the total price based on certain rules
   */
  public function calculateDelivery(float $total): float {
    //sort delivery rules by limit
    usort($this->deliveryRules, function($a, $b) {
      return $a['limit'] <=> $b['limit'];
    });

    foreach ($this->deliveryRules as $rule) {
      if ($total < $rule['limit']) {
        return $rule['cost'];
      }
    }

    return 0;
  }

  /**
   * Add a delivery rule
   */
  public function addDeliveryRule(int $limit, float $cost): void {
    if ($limit <= 0 || $cost < 0) {
      throw new \InvalidArgumentException("Invalid delivery rule.");
    }
    $this->deliveryRules[] = ['limit' => $limit, 'cost' => $cost];
  }
}