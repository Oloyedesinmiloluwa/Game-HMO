## Game

A Game App Built with Laravel

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

Setup

- copy .env.example to .env and update
- create database for the app and for test
- run test with composer test
- serve the app with php artisan serve
- you may use the docker file to run with docker

Generate data

php artisan php artisan generate:data

Heroku url
https://games-hmo.herokuapp.com/api/v1

Sample requests

GET players http://localhost:8001/api/v1/players
GET games http://localhost:8001/api/v1/games
