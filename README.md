# lamia-test-task-php

This client is currently available and running on [Heroku](https://lamia-php-client.herokuapp.com) (as of 2020.12.05).

## Operating instructions

In order to run the project locally use:

```bash
composer install
php artisan serve
```

Keep in mind, your **Postgres DB** should also be active for everything to work.

## Platform

This project and its dependencies are supported on **Ubuntu** and **Heroku VM**.

## Stack

- Laravel
- Apache2 (on Heroku)
- Postgres

## Environmant variables

| Name                         | Description                                                   |
| ---------------------------- | ------------------------------------------------------------- |
| **`APP_DEBUG`**              | `true` or `false`                                             |
| **`APP_ENV`**                | `local` or `production`                                       |
| **`APP_KEY`**                | Base64-prefixed secret key                                    |
| **`APP_URL`**                | Deployment host root url                                      |
| **`GET_BOOK_ENDPOINT_URL`**  | Url of the **REST API** enpoint mirroring **OMDb API**        |
| **`GET_MOVIE_ENDPOINT_URL`** | Url of the **REST API** enpoint mirroring **OpenLibrary API** |

## API

| Route                        | Type | Description                                       |
| ---------------------------- | ---- | ------------------------------------------------- |
| **`/`**                      | Page | Main application page. JWT bearer token required. |
| **`/login`**                 | Page | Login page                                        |
| **`/registration`**          | Page | Registration page                                 |
| **`/search/book`**           | Page | Book search page                                  |
| **`/search/movie`**          | Page | Movie search page                                 |
| **`/api/getBook`**           | API  | Book data API                                     |
| **`/api/getMovie`**          | API  | Movie data API                                    |
| **`/api/auth/login`**        | API  | Login API                                         |
| **`/api/auth/logout`**       | API  | Logout API                                        |
| **`/api/auth/registration`** | API  | Registration API                                  |

## Behaviour Flow

1. Registration
2. Login -> **JWT Token**
3. Addressing **Book API** or **Movie API** (Postman)
