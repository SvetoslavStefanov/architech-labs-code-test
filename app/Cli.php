<?php

namespace app;

use InvalidArgumentException;
use lib\OfferType;

class Cli {
  protected Basket $basket;
  protected Catalogue $catalogue;

  public function __construct() {
    $this->initialize();
  }

  private function initialize(): void {
    $this->catalogue = new Catalogue();
    $this->basket = new Basket($this->catalogue);
  }

  private function prompt(string $message): string {
    $this->write($message, false);
    return trim(fgets(STDIN));
  }

  private function write(string $message, bool $addNewLine, string $color = 'default'): void {
    $colors = [
      'red' => "\033[0;31m",
      'green' => "\033[0;32m",
      'default' => "\033[0m"
    ];

    echo $colors[$color] . $message . $colors['default'] . ($addNewLine ? "\n" : '');
  }

  /**
   * Run the CLI application
   */
  public function run() {
    while (true) {
      $this->printMenu();
      $choice = $this->prompt("\nEnter your choice: ");

      switch ($choice) {
        case 1:
          $this->setDefaultCatalogData();
          break;
        case 2:
          $this->addItemsToCatalogue();
          break;
        case 3:
          $this->addItemToBasket();
          break;
        case 4:
          $this->setDeliveryRules();
          break;
        case 5:
          $this->addOffers();
          break;
        case 6:
          $this->calculate();
          break;
        case 7:
          $this->startOver();
          break;
        case 8:
          $this->printCatalogue();
          break;
        case 9:
          $this->printBasket();
          break;
        default:
          $this->write("Invalid choice. Please try again.", true, 'red');
      }
    }
  }

  /**
   * Print the menu
   */
  protected function printMenu(): void {
    $items = [
      'Set default catalogue',
      'Add items to the catalog',
      'Add items to the basket',
      'Set delivery rules',
      'Apply offers',
      'Calculate',
      'Start over',
      'Print catalogue',
      'Print basket',
      'Load same data as in the example',
    ];

    $this->write("\nMenu\n", true);
    foreach ($items as $index => $item) {
      $this->write(($index + 1) . ". $item", true);
    }
  }

  /**
   * Add items to the catalogue
   */
  protected function addItemsToCatalogue(): void {
    while (true) {
      $name = $this->prompt("Enter product name: ");
      $price = $this->prompt("Enter product price: ");
      $code = $this->prompt("Enter product code: ");

      if (empty($name) && empty($price) && empty($code)) {
        $this->write("Nothing added, back to the menu", true, 'green');
        break;
      }

      try {
        $product = new Product($name, $price, $code);
        $this->catalogue->addProduct($product);
        $this->write("Product added. ", false, 'green');
        $continue = $this->prompt("Do you want to add another item? (yes/no): ");

        if (strtolower($continue) !== 'yes') {
          $this->write("Catalogue updated.", true, 'green');
          break;
        }
      } catch (InvalidArgumentException $e) {
        $this->write("Error: " . $e->getMessage(), true, 'red');
      }
    }
  }

  /**
   * Add items to the basket
   */
  protected function addItemToBasket(): void {
    if (empty($this->catalogue->getProducts())) {
      $this->write("No products in the catalogue. Please add some products first.", true, 'red');
      return;
    }

    $this->printCatalogue();

    while (true) {
      $productCode = $this->prompt("Enter product code to add to basket, or press Enter to finish:: ");
      try {
        if (empty($productCode)) {
          break;
        }
        $this->basket->add($this->catalogue->findProductByCode($productCode));
        $this->write("Product added to basket.", true, 'green');

        $continue = $this->prompt("Do you want to add another product? (yes/no): ");
        if (strtolower($continue) !== 'yes') {
          break;
        }
      } catch (\Exception $e) {
        $this->write("Error: " . $e->getMessage(), true, 'red');
      }
    }
  }

  /**
   * Set delivery rules
   */
  protected function setDeliveryRules(): void {
    while (true) {
      $limit = (float)$this->prompt("Enter delivery limit amount (in $$): ");
      $cost = (float)$this->prompt("Enter delivery cost: ");

      if (empty($limit) && empty($cost)) {
        $this->write("Nothing added, back to the menu", true, 'green');
        break;
      }

      try {
        $this->basket->addDeliveryRule($limit, $cost);
        $this->write("Delivery rule added.", true, 'green');
        $continue = $this->prompt("Do you want to add another rule? (yes/no): ");

        if (strtolower($continue) !== 'yes') {
          break;
        }
      } catch (InvalidArgumentException $e) {
        $this->write("Error: " . $e->getMessage(), true, 'red');
        $this->setDeliveryRules();
      }
    }
  }

  /**
   * Add offers
   */
  protected function addOffers(): void {
    $this->write("Our available offers", true);
    $offers = OfferType::cases();
    foreach ($offers as $index => $offerType) {
      $this->write("Offer " . ($index + 1) . ": " . $offerType->description(), true);
    }

    while (true) {
      $input = $this->prompt("Enter the number of the offer to add, or press Enter to finish: ");
      if (empty($input)) {
        break;
      }

      try {
        $offerIndex = (int)$input - 1;
        $this->basket->addOffer($offers[$offerIndex]);

        $continue = $this->prompt("Do you want to add another offer to the basket? (yes/no): ");
        if (strtolower($continue) !== 'yes') {
          return;
        }
      } catch (InvalidArgumentException $e) {
        $this->write("Error: " . $e->getMessage(), true, 'red');
      }
    }

    $this->write("Offers added successfully.", true, 'green');
  }

  /**
   * Calculate the total price
   */
  protected function calculate(): void {
//    $this->basket->add($this->catalogue->findProductByCode('B01'));
//    $this->basket->add($this->catalogue->findProductByCode('B01'));//pre: 15.9, after: 11,925
//    $this->basket->add($this->catalogue->findProductByCode('R01'));
//    $this->basket->add($this->catalogue->findProductByCode('R01'));
//    $this->basket->add($this->catalogue->findProductByCode('R01'));//pre: 98.85, after: 82,375
//
//    $this->basket->addDeliveryRule(50, 4.95);
//    $this->basket->addDeliveryRule(90, 2.95);
//    $this->basket->addOffer(OfferType::BUY_ONE_GET_ONE_HALF);

    //print if basket is empty
    $res = $this->printBasket();
    if (!$res) {
      return;
    }
    $this->write("Total: $" . $this->basket->total(), true, 'green');
  }

  /**
   * Start over, reset all products in the catalogue and basket
   */
  protected function startOver(): void {
    $this->initialize();
    $this->write("Data reset. You can start over.", true, 'green');
  }

  /**
   * Set the default catalogue, based on the .pdf provided
   */
  protected function setDefaultCatalogData(): void {
    $items = [
      'R01' => ['name' => 'Red Widget', 'price' => 32.95],
      'G01' => ['name' => 'Green Widget', 'price' => 24.95],
      'B01' => ['name' => 'Blue Widget', 'price' => 7.95]
    ];

    foreach ($items as $code => $item) {
      $product = new Product($item['name'], $item['price'], $code);
      $this->catalogue->addProduct($product);
    }

    $this->write("Default catalogue set.", true, 'green');
  }

  protected function printCatalogue(): void {
    if (empty($this->catalogue->getProducts())) {
      $this->write("Catalogue is empty.", true);
      return;
    }

    $this->write("Our product catalogue: ", true);
    foreach ($this->catalogue->getProducts() as $product) {
      $this->write($product->getCode() . " - " . $product->getName() . " ($" . $product->getPrice() . ")", true);
    }
  }

  protected function printBasket(): bool {
    if (empty($this->basket->getProducts())) {
      $this->write("Basket is empty.", true);
      return false;
    }

    $this->write("Our basket: ", true);
    foreach ($this->basket->getProducts() as $product) {
      $this->write($product->getCode() . " - " . $product->getName() . " ($" . $product->getPrice() . ")", true);
    }

    return true;
  }
}