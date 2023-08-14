# Laravel-9 Todo List

> A Laravel-9 Vue Todo List App


## Features

- Laravel 8
- Vue + VueRouter + Vuex + VueI18n + ESlint
- Pages with dynamic import and custom layouts
- Login, register, email verification
- Authentication with JWT
- Bootstrap 5 + Font Awesome 5 (optional)

## Installation

- `git clone https://github.com/anujjaha/lara-9-todo-list.git`
- Edit `.env` and set your database connection details
- (When installed via git clone or download, run `php artisan key:generate` and `php artisan jwt:secret`)
- `php artisan migrate`
- `php artisan db:seed`
- `npm install`

## Usage

#### Development

```bash
npm run dev
```

> Login with test user admin@admin.com / Admin@12345
> Access page/url '/home' 
> Try to add your first todo

## Run Locally or use VirtualHost
- `php artisan serve`


## Email Verification

To enable email verification make sure that your `App\User` model implements the `Illuminate\Contracts\Auth\MustVerifyEmail` contract.

## Testing

```bash
# Run unit and feature tests
vendor/bin/phpunit

# Run Dusk browser tests
php artisan dusk
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.
