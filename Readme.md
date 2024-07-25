# Author
- Svetoslav Stefanov
- Email: svetliooo@gmail.com

# How to use
- Clone the repository ```git clone https://github.com/SvetoslavStefanov/architech-labs-code-test.git```
- Navigate to the project directory ```cd architech-labs-code-test```
- Run the Docker container ```docker-compose up```
- Open another terminal at the same directory and enter inside the container: ```docker compose exec php bash```
- Inside the container run ```php index.php```

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