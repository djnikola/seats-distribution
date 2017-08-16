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

API documentation is available via Postman.

<div class="postman-run-button"
data-postman-action="collection/import"
data-postman-var-1="de320413b2f1b4fb9731"></div>
<script type="text/javascript">
  (function (p,o,s,t,m,a,n) {
    !p[s] && (p[s] = function () { (p[t] || (p[t] = [])).push(arguments); });
    !o.getElementById(s+t) && o.getElementsByTagName("head")[0].appendChild((
      (n = o.createElement("script")),
      (n.id = s+t), (n.async = 1), (n.src = m), n
    ));
  }(window, document, "_pm", "PostmanRunObject", "https://run.pstmn.io/button.js"));
</script>

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

API documentation is available via Postman.

<div class="postman-run-button"
data-postman-action="collection/import"
data-postman-var-1="de320413b2f1b4fb9731"></div>
<script type="text/javascript">
  (function (p,o,s,t,m,a,n) {
    !p[s] && (p[s] = function () { (p[t] || (p[t] = [])).push(arguments); });
    !o.getElementById(s+t) && o.getElementsByTagName("head")[0].appendChild((
      (n = o.createElement("script")),
      (n.id = s+t), (n.async = 1), (n.src = m), n
    ));
  }(window, document, "_pm", "PostmanRunObject", "https://run.pstmn.io/button.js"));
</script>

## Built With

* [Symfony](https://symfony.com/) - The web framework used Symfony 3

## Authors

* **Nikola Dordevic**
