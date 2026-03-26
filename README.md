# Symfony Base Template

<p>
<!-- Version Badge -->
<img src="https://img.shields.io/badge/Version-1.0.0-blue" alt="Version 1.0.0">
<!-- License Badge -->
<img src="https://img.shields.io/badge/License-GPL--3.0--or--later-40adbc" alt="License GPL-3.0-or-later">
</p>

A _highly opinionated_, ready-to-use Symfony 7 app starter template.

## Installation

```bash
composer create-project cloudbase/symfony-base my-project
```

## What's Included?

- Symfony 7.3
- Latte Templating Engine
- Full Authentication System: Login, Registration, Password Reset and Email Verification
- Doctrine ORM/DBAL
- NPM with Vite
- Vue JS
- Hot Module Reloading
- TailwindCSS
- TypeScript
- SCSS
- Email Builder

## Basic Usage

After installation, run `npm install` to install node dependencies. This has been excluded from the auto-setup script to
allow you to run this in your container or your own environment without requiring node/npm locally.

Update your projects `.env` file with your database credentials and run the SQL manually (`data/setup.sql`).

## Customising

This is just a template project with some helpful features baked in. Modify anything and everything to suit your needs.

Your app homepage route is defined in `src/Application/IndexController.php` and the template is located 
at `templates/application/index.latte` - remove the default content and replace it with your own.

All the authentication code has been included and can be found in the `src/Authentication` directory. Out of the box 
this includes:

- Login
- Registration
- Password Reset
- Email Verification
- Entities for: User, Verification Token and Password Reset Token

## Available Routes

Out of the box, this project includes the following routes:

| Name                                    | Method       | Path                                 |
|-----------------------------------------|--------------|--------------------------------------|
| `app_health_check_database_connection`  | `GET`        | `/health-check/database-connection`  |
| `app_health_check_default_tables_exist` | `GET`        | `/health-check/default-tables-exist` |
| `app_health_check_php_version`          | `GET`        | `/health-check/php-version`          |
| `app_health_check_symfony_version`      | `GET`        | `/health-check/symfony-version`      |
| `app_index`                             | `GET`        | `/`                                  |
| `authenticate`                          | `GET`        | `/authenticate`                      |
| `authenticate_request_password_reset`   | `GET`,`POST` | `/authenticate/password-reset`       |
| `authenticate_password_reset`           | `GET`,`POST` | `/authenticate/password-reset/reset` |
| `authenticate_login`                    | `GET`,`POST` | `/authenticate/login`                |
| `authenticate_logout`                   | `GET`        | `/authenticate/logout`               |
| `authenticate_get_logged_in_user`       | `GET`        | `/authenticate/current-user`         |
| `authenticate_register`                 | `POST`       | `/authenticate/register`             |
| `authenticate_verify_email`             | `GET`        | `/authenticate/verify`               |