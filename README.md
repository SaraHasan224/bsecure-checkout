<p align="center">
  <img src="https://bsecure-dev.s3-eu-west-1.amazonaws.com/dev/react_app/assets/secure_logo.png" width="400px" position="center">
</p>

[![Latest Stable Version](https://poser.pugx.org/bsecure/universal-checkout/v)](//packagist.org/packages/bsecure/universal-checkout) [![Total Downloads](https://poser.pugx.org/bsecure/universal-checkout/downloads)](//packagist.org/packages/bsecure/universal-checkout) [![Latest Unstable Version](https://poser.pugx.org/bsecure/universal-checkout/v/unstable)](//packagist.org/packages/bsecure/universal-checkout) [![License](https://poser.pugx.org/bsecure/universal-checkout/license)](//packagist.org/packages/bsecure/universal-checkout)


bSecure Checkout 
=========================
 Pakistan's first universal checkout solution for ecommerce stores built on woocommerce, magento, shopify and more
## About bSecure Checkout ##
bSecure is a one-click checkout solution for selling your products all across the globe instantly. We bring everything together that’s required to manage and streamline your product checkout for an instant buying experience. A security-centric approach with every transaction encrypted and never compromising on transparency of user needs and expectations.

## Requirements
- bSecure Builder Panel Access
- php ^7.2.5|^8.0


## Getting started
Install via composer
```bash
composer require --dev bSecure/univeral-checkout
```
Publish package config if you want customize default values
```bash
php artisan vendor:publish --provider="bSecure\SDK\CreateOrderServiceProvider"
```

## Installation

Please check the official bSecure installation guide for server requirements before you start. [Official Documentation](https://help.bsecure.pk/en/)

Clone the repository

    git clone https://github.com/SaraHasan224/bsecure-checkout.git

Switch to the repo folder

    cd laravel-realworld-example-app

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone git@github.com:SaraHasan224/bsecure-checkout.git
    cd laravel-realworld-example-app
    composer install
    cp .env.example .env
    

The api can be accessed at [http://localhost:8000/api](http://localhost:8000/api).

## API Specification

This application adheres to the api specifications set by the [bSecure - Universal Checkout](https://github.com/SaraHasan224/bsecure-checkout) team. This helps mix and match any backend with any other frontend without conflicts.

## Folders

- `app` - Contains all the Eloquent models
- `app/Http/Controllers/Api` - Contains all the api controllers
- `app/Http/Middleware` - Contains the JWT auth middleware
- `app/Http/Requests/Api` - Contains all the api form requests
- `app/RealWorld/Favorite` - Contains the files implementing the favorite feature
- `app/RealWorld/Filters` - Contains the query filters used for filtering api requests
- `app/RealWorld/Follow` - Contains the files implementing the follow feature
- `app/RealWorld/Paginate` - Contains the pagination class used to paginate the result
- `app/RealWorld/Slug` - Contains the files implementing slugs to articles
- `app/RealWorld/Transformers` - Contains all the data transformers
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `database/seeds` - Contains the database seeder
- `routes` - Contains all the api routes defined in api.php file
- `tests` - Contains all the application tests
- `tests/Feature/Api` - Contains all the api tests

## Environment variables

- `.env` - Environment variables can be set in this file

----------

# Testing API

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api

Request headers

| **Required** 	| **Key**              	| **Value**            	|
|----------	|------------------	|------------------	|
| Optional 	| Authorization    	| Token {JWT}      	|

Refer the [api specification](#api-specification) for more info.

----------
 
# Authentication
 
This applications uses JSON Web Token (JWT) to handle authentication. The token is passed with each request using the `Authorization` header with `Token` scheme. The JWT authentication middleware handles the validation and authentication of the token. Please check the following sources to learn more about JWT.
 
- https://jwt.io/introduction/
- https://self-issued.info/docs/draft-ietf-oauth-json-web-token.html

----------

# Cross-Origin Resource Sharing (CORS)
 
This applications has CORS enabled by default on all API endpoints. The default configuration allows requests from `http://localhost:3000` and `http://localhost:4200` to help speed up your frontend testing. The CORS allowed origins can be changed by setting them in the config file. Please check the following sources to learn more about CORS.
 
- https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS
- https://en.wikipedia.org/wiki/Cross-origin_resource_sharing
- https://www.w3.org/TR/cors