# Symfony Base Template

<p>
<!-- Version Badge -->
<img src="https://img.shields.io/badge/Version-1.0.0-blue" alt="Version 1.0.0">
<!-- License Badge -->
<img src="https://img.shields.io/badge/License-GPL--3.0--or--later-40adbc" alt="License GPL-3.0-or-later">
</p>

A _highly opinionated_, ready-to-use Symfony 7 app starter template.

## Table of Contents

- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Features](#features)
- [Project Structure](#project-structure)
- [Standards & Quality Tools](#standards--quality-tools)
- [Development Workflow](#development-workflow)
- [Available Routes](#available-routes)
- [Customizing](#customizing)

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 8.3+** - Required for Symfony 7.3
- **Composer** - Dependency management
- **Node.js & npm** - Used for frontend assets (Vue.js, Vite, TailwindCSS). Only required on your machine if you are 
  building your assets locally (i.e. not inside a container)

### Development Environment

This project can run in various environments:

- **Local PHP Server**: Use `php -S localhost:8000 -t public/` for quick testing
- **Docker**: Recommended for production-like development (PHP, Nginx, MySQL, Mailcatcher)
- **MySQL Database**: Can use local or remote database connections
- **Email**: Works with local Mailcatcher or remote services like Mailtrap

## Installation

```bash
composer create-project winningsoftware/symfony-base my-project
```

## Features

- **Symfony 7.3** - Latest stable Symfony version
- **Latte Templating Engine** - Clean, intuitive templating
- **Full Authentication System** - Login, Registration, Password Reset and Email Verification
- **Doctrine ORM/DBAL** - Database abstraction layer
- **Frontend Stack** - NPM with Vite, Vue.js 3, TailwindCSS, TypeScript, SCSS
- **Email Builder** - Built-in email template system
- **Health Checks** - Database connection, table existence, PHP/Symfony version checks
- **Standards Enforcement** - PHPStan (max level), PHP-CS-Fixer, ESLint

## Project Structure

```
src/
├── _Core/              # Core framework components
│   ├── Controller/     # Base controllers and utilities
│   ├── Entity/         # Base entity classes
│   └── ...
├── Application/        # Main application code
│   ├── Command/        # Console commands
│   ├── Controller/     # Application controllers
│   └── ...
├── Authentication/     # Authentication system
│   ├── Controller/     # Auth controllers
│   ├── Entity/         # User, tokens, etc.
│   └── ...
└── Kernel.php          # Symfony kernel

assets/
├── Plugin/            # Vue.js plugins
│   └── AuthCore/       # Authentication UI components
├── scripts/           # TypeScript/Vue components
├── styles/            # SCSS/Tailwind styles
└── ...

templates/
├── application/       # Main application templates
├── authentication/    # Auth templates
└── ...
```

## Standards & Quality Tools

This project enforces high code quality standards using:

### PHP Tools

**PHPStan** - Static analysis tool for PHP
```bash
composer stan
```
- Configuration: `phpstan.neon`
- Level: `max` (most strict)
- Includes Doctrine extension for entity analysis

**PHP-CS-Fixer** - Code style fixer
```bash
composer cs
```
- Automatically fixes code style issues
- Run with `--diff` to see changes before applying
- Apply fixes: `composer cs -- --allow-risky=yes`

### JavaScript/TypeScript Tools

**ESLint** - JavaScript/TypeScript linter
```bash
npm run lint
```
- Configuration: `eslint.config.mts`
- Lints `.ts`, `.vue` files in `assets/`
- Includes Vue.js and TypeScript support

## Development Workflow

### Getting Started
1. Install dependencies:
    ```bash
    composer install
    npm install
    ```

2. Configure environment settings:
    ```bash
    cp .env.template .env 
    ```

3. (Optional) If using MySQL, you can run the out of the box DB setup for the authentication and email system:
    ```bash
    php bin/console app:database:setup
    ```

4. Build assets:
    ```bash
    symfony serve -d
    npm run vite:build
    ```

#### Hot Module Reloading
To make use of Vite's Hot Module Reloading, you will need containers setup to expose port 3000 of the PHP container. 
HMR **will not** work out of the box - check out the `server` block in `vite.config.ts` and adapt this to suit your 
setup.

### Quality Checks
Run these before committing:
```bash
# Check PHP code quality
composer stan

# Fix PHP code style
composer cs

# Check JavaScript/TypeScript quality
npm run lint
```

### Common Commands

- **Clear cache**: `php bin/console cache:clear`
- **Build assets**: `npm run vite:build`

## Basic Usage

After installation, run `npm install` to install node dependencies. This has been excluded from the auto-setup script to
allow you to run this in your container or your own environment without requiring node/npm locally.

Update your projects `.env` file with your database credentials and run the SQL manually (`data/setup.sql`).

## Customizing

This is just a template project with some helpful features baked in. Modify anything and everything to suit your needs.

Your app homepage route is defined in `src/Application/IndexController.php` and the template is located 
at `templates/application/index.latte` - remove the default content and replace it with your own.

### Authentication

All the backend authentication code has been included and can be found in the `src/Authentication` directory. Out of the 
box this includes:

- Login
- Registration
- Password Reset
- Email Verification
- Entities for: User, Verification Token and Password Reset Token

For the frontend side of the built-in Authentication system, check out the `assets/Plugin/AuthCore` directory.

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