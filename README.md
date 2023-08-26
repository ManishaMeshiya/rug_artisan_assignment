<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel Project

This project is created with the Laravel framework with all necessary input validations, rate limits, API tokens, and user access roles.

## Installation
- [Step:1]: Clone repository (git clone https://github.com/ManishaMeshiya/rug_artisan_assignment.git)
- [Step:2]: Run the Command "composer install" in the terminal at project directory
- [Step:3]: Generate .env file from .env.example
- [Step:4]: Create an empty Database and set credentials in the .env file
- [Step:5]: Run Command "php artisan config: cache" & "php artisan migrate"
- [Step:6]: Run command "php artisan db: seed --class=AdminSeeder" to create the default Admin

## Apis Route

For Authentication, here is the PASSPORT package and all APIs need to be tokens to get a response. Apis are created with version 1 prefix and input validations such as Mobile number must have 10 digits, Strong Password, email, etc...

-> user/signup
    - Method: POST
    - Param: name, email, code, mobile_number, password
-> user/login
    - Method: POST
    - Param: username(email or name), password
-> user/transaction-list
    - Method: GET
-> user/create-transaction
    - Method: POST
    - Param: user_code, amount
-> user/update-transaction/{id}
    - Method: PUT
    - Param: note, amount
-> user/delete-transaction/{id}
    - Method: DELETE
-> user/logout

## Security
- For Preventing XSS, create one middleware with the name XSS and apply it on all routes.
- For rate limit, set API rate limit in routes, and user can call one time at a one minute.
- For Authentication, Use the PASSPORT package.
- Apply the Laravel validation rule.