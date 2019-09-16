# Karomap Laravel Test

Test for laravel developer



## Requirements

- PHP >= 7.2
- Composer PHP package manager
- MySQL
- Node.js



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

- Copy `.env.example` to `.env` and change database configuration according to your local environment then create the database
  
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
