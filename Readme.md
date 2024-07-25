# Author
- Svetoslav Stefanov
- Email: svetliooo@gmail.com

# Overview
- Acme Widget Co are the leading provider of made up widgets and they’ve contracted you to
  create a proof of concept for their new sales system.
- They sell three products:
- - Red Widget (Product Code: R01) - $32.95
- - Green Widget (Product Code: G01) - $24.95
- - Blue Widget (Product Code: B01) - $7.95

    
- To incentivise customers to spend more, delivery costs are reduced based on the amount spent. Orders under $50 cost $4.95. For orders under $90, delivery costs $2.95. Orders of $90 or more have free delivery.
- They are also experimenting with special offers. The initial offer will be “buy one red widget, get the second half price”


- Your job is to implement the basket which needs to have the following interface
- - It is initialised with the product catalogue, delivery charge rules, and offers (the format of how these are passed it up to you)
- - It has an add method that takes the product code as a parameter.
- - It has a total method that returns the total cost of the basket, taking into account the delivery and offer rules.

# How to use
- Clone the repository ```git clone https://github.com/SvetoslavStefanov/architech-labs-code-test.git```
- Navigate to the project directory ```cd architech-labs-code-test```
- Run the Docker container ```docker-compose up```
- Open another terminal at the same directory and enter inside the container: ```docker compose exec php bash```
- Inside the container run ```php index.php```
- Run phpunit tests ```composer phpunit```
- Run PHPStan ```composer phpstan```

From this point you'll navigate our Menu from which you can choose the desired action.

# Features
- Separation of logic (different classes for each of the available objects - Basket, Product, Offer, Catalogue)
- CLI Menu interface
- Error handling
- No hardcoded values
- Using Interfaces
- Dependency Injection
- Dockerized environment
- PHP Unit tests
- PHPStan

