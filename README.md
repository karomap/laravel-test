[![Build Status](https://travis-ci.org/karomap/laravel-test.svg?branch=master)](https://travis-ci.org/karomap/laravel-test)


# Karomap Laravel Test

Test for laravel developer



## Requirements

- [PHP](https://www.php.net/) >= 7.2 with the following extensions enabled:
  - bcmath
  - ctype
  - json
  - mbstring
  - openssl
  - PDO
  - pdo_sqlite
  - Phar
  - tokenizer
  - xml
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/en/) *(optional)*

> ***Note:***  
> Node.js is required for compiling assets using [Laravel Mix](https://laravel.com/docs/master/mix)



## Test Instruction

- Fork this project
- Run the [**installation**](#installation) steps
- Run the tests
  ```bash
  $ ./vendor/bin/phpunit -v
  ```
- Some tests will not pass, fix the bugs and make the application passes all tests
- Create pull request to this repository
- Good Luck!



## Installation

- Clone this repository and change working directory to this project
  ```bash
  $ git clone https://github.com/<your-github-user-name>/laravel-test karomap-laravel-test

  $ cd karomap-laravel-test
  ```

  > ***Note:***  
  > Change the repository URL to your forked version of this project

- Copy `.env.local` to `.env`
  ```bash
  $ cp .env.local .env
  ```
  
- Create sqlite database file
  ```bash
  # Application database
  $ touch database/database.sqlite

  # Testing database
  $ touch database/database-testing.sqlite
  ```

- Install PHP dependencies
  ```bash
  $ composer install
  ```
  
- Generate new application key
  ```bash
  $ php artisan key:generate
  ```

- Migrate and seed the database
  ```bash
  $ php artisan migrate --seed
  ```

- Run the development server
  ```bash
  $ php artisan serve
  ```


---
[*Karomap Semesta*](https://www.karomap.com)
