<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Checkout

## Getting started
Necessary sofwares to run this project:

    - docker
    - docker-compose

To start the server is necessary to run:

``./vendor/bin/sail up``

Might be necessary to install the projects dependencies first to be able to run sail.

### Migrations

To run the migrations and also seed the database with some products is necessary to run the following command:

``./vendor/bin/sail artisan migrate:fresh --seed``

### Front-end

Front-end application can be found accessing `localhost`. Might be necessary to install the front-end packages running:

``./vendor/bin/sail npm install`` and ``./vendor/bin/sail npm run dev``

Once everything is install you should be ready to go.

## Available endpoints (REST API)

    - localhost/api/v1/products
    - localhost/api/v1/cart
    - localhost/api/v1/cart/{cartId}/items
