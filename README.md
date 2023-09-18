## Laravel Rest API 
This project demonstrates my ability to design, develop, and maintain RESTful APIs with a focus on security, performance, and usability. It highlights my expertise in Laravel, a popular PHP framework for web development, and my commitment to best practices in API development.


## API Documentation
- https://documenter.getpostman.com/view/5105782/2s9YC1XZwk

## Prerequisites

- PHP 8.1 or higher
- Composer 
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