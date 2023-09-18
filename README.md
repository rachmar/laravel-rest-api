## RM Backend


## API Documentation
- https://documenter.getpostman.com/view/5105782/2s9YC1XZwk

## Prerequisites

- PHP 8.1 or higher
- Composer 
- Node & NPM
- Git

## Installation

- Clone this repository
- Go to your terminal and cd `rachmar-backend` folder then `composer install`
If you encounter problems, you can add this tag `--ignore-platform-req`, Please disregard if there's no error occurred
- Create your `.env` file and add to the database credentials
- Go to your terminal again the copy and paste this one line command
`php artisan migrate:refresh && php artisan db:seed && php artisan passport:install && php artisan storage:link`
This will migrate and seed all the default data needed
- To run the project, just simply use `php artisan serve`

## Project Composition & Highlights
- Laravel 10
- Laravel Passport
- Spatie QueryBuilder
- API Resource & Collection
- TaskPermission Middleware
- TaskManager Traits
- Proper API Response
- Proper Model Relationship