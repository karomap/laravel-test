# Karomap Laravel Test

Test for laravel developer



## Requirements

- PHP >= 7.2 with the following extensions enabled:
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
- [Node.js](https://nodejs.org/en/)



## Installation

- Clone this repository and change working directory to this project
  ```bash
  $ git clone https://github.com/karomap/laravel-test karomap-laravel-test

  $ cd karomap-laravel-test
  ```

  > Change the repository URL to your forked version of this project

- Install PHP dependencies
  ```bash
  $ composer install
  ```

- Install Node.js modules for compiling assets (Laravel Mix)
  ```bash
  $ npm install
  ```

- Copy `.env.local` to `.env`
  ```bash
  $ cp .env.local .env
  ```
  
- Create database file
  ```bash
  # Application database
  $ touch database/database.sqlite

  # Testing database
  $ touch database/database-testing.sqlite
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



## Test Instruction

- Fork this project
- Run the installation steps
- Run the tests
  ```bash
  $ ./vendor/bin/phpunit -v
  ```
- Some tests will not pass, fix the bugs and make the application passes all tests
- Good Luck


---
[*Karomap Semesta*](https://www.karomap.com)
