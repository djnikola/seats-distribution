# Seats distribution in German's states.

Create a RESTful API application to distribute seats for different federal states parliamentary elections.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. 

### Installing

Go to your web directory and type:
```
git clone https://github.com/djnikola/seats-distribution.git
```

then go into seats-distribution/ folder:
```
cd seats-distribution/
```

then run:
```
composer install
```

then create a database:
```
php bin/console doctrine:database:create
```

and update database schema:
```
php bin/console doctrine:schema:update --force
```

## Running the tests

After installing in project root directory run this command:
```
php bin/console server:run
```

Now application is ready to use.


## Running the tests

Functional test you can run via Postman.

API documentation is available via Postman [here](https://www.getpostman.com/collections/de320413b2f1b4fb9731).


### And Function tests

Run this command in projects' root folder to run all tests:
```
vendor/behat/behat/bin/behat
```

### And PHP Unit tests

Run this command in projects' root folder to run all tests:
```
vendor/phpunit/phpunit/phpunit
```

```
Give an example
```

## Documentation 

API documentation is available via Postman [here](https://www.getpostman.com/collections/de320413b2f1b4fb9731).

## Built With

* [Symfony](https://symfony.com/) - The web framework used Symfony 3

## Authors

* **Nikola Dordevic**
