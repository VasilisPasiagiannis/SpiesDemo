
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Spy Management System

## Table of Contents
    Features
    Setup Instructions
    Architecture Overview
    Testing

## Features
    CRUD Operations: Create, Read, Update(not implemented), and Delete(not implemented) spies.
    Enum Validations: Enforces valid agency values using PHP Enums.
    Pagination and Filtering: Supports paginated listing with filters and sorting.
    Rate-Limiting: Implements rate-limiting for specific endpoints.
    CQRS: Clear separation of command and query responsibilities.
    Factories and Seeders: Generate dummy data for testing and development.


## Setup Instructions
    PHP 8.3
    Composer
    MySQL
    Laravel 11

## Installation

### Demo Credentials
    API: api@test.com
    Password: 123456

### 1. Download
    git clone https://github.com/VasilisPasiagiannis/SpiesDemo.git
    cd SpiesDemo

### 2. Environment Files
This package ships with a .env.example file in the root of the project.

You must rename this file to just .env

Note: Make sure you have hidden files shown on your system.

### 3. Composer
Laravel project dependencies are managed through the PHP Composer tool. The first step is to install the depencencies by navigating into your project in terminal and typing this command:

    composer install

### 4. NPM/Yarn
In order to install the Javascript packages for frontend development, you will need the Node Package Manager, and optionally the Yarn Package Manager by Facebook (Recommended)

If you only have NPM installed you have to run this command from the root of the project:

    npm install

### 5. Create Database
You must create your database on your server and on your .env file update the following lines:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=spiesdemo
    DB_USERNAME=root
    DB_PASSWORD=

Change these lines to reflect your new database settings.

### 6. Artisan Commands
The first thing we are going to do is set the key that Laravel will use when doing encryption.

    php artisan key:generate

You should see a green message stating your key was successfully generated. As well as you should see the APP_KEY variable in your .env file reflected.

It's time to see if your database credentials are correct.

We are going to run the built in migrations to create the database tables:

    php artisan migrate --seed

You should see a message for each table migrated, if you don't and see errors, than your credentials are most likely not correct.

### 7. NPM Run '*'
Now that you have the database tables and default rows, you need to build the styles and scripts.

These files are generated using Laravel Mix, which is a wrapper around many tools, and works off the vite.config.js in the root of the project.

You can build with:

    npm run dev 
    Or 
    npm run build

The available commands are listed at the top of the package.json file under the 'scripts' key.

You will see a lot of information flash on the screen and then be provided with a table at the end explaining what was compiled and where the files live.

At this point you are done, you should be able to hit the project in your local browser and see the project, as well as be able to log in with the administrator and view the backend.

###  8. Start the application:

    php artisan serve


## Architecture Overview
This application follows a CQRS (Command Query Responsibility Segregation) pattern, alongside Laravel's default MVC structure.

### Key Components
    1 Commands:
        Handle actions that change state (e.g., creating or updating a spy).
        Found in App\Domains\Spies\Commands.

    2. Queries:
        Handle data retrieval operations (e.g., fetching spies with filters).
        Found in App\Domains\Spies\Repositories
        e.g. App\Domains\Spies\Repositories\SpyRepository
             App\Domains\Spies\Repositories\SpyRepositoryInterface

    3. Events:
        Handle domain events (e.g., spy creation).
        Found in App\Domains\Spies\Events. 
        
        # To Run Events: php artisan queue:work --queue=spies-queue

    4.Models:
        Represent database entities or DTOs.
        e.g. App\Domains\Spies\Models\Spy
             App\Domains\Spies\Models\SpyDTO

    5. Factories and Seeders:
        Automatically generate data for testing or local development.
        Found in database/factories and database/seeders.

    6. Enums:
        Define constant values for agencies (App\Domains\Agencies\Models\AgencyEnum).

    7. Rate-Limiting:
        Implemented in routes for specific endpoints (e.g., api\spies\get) 
        
        Configured in app/Providers/RouteServiceProvider.php
        class RouteServiceProvider   
            RateLimiter::for('random-spies', function ($request) {
                return Limit::perMinute(10)->by($request->ip());
            });

        Configured via middleware in routes/api.php. 
            ->middleware('throttle:random-spies')

## Directory Structure
    app/
    ├── Domains/
    │   ├── Agencies/            # Handles Agencies
    │   │   ├── Models/          # 
    │   │   │   ├── AgencyEnum   # Enum for agencies
    │   │   
    │   │   Events/              # Handles Multiple Events for Spies
    │   │   ├── Models/          # Event Types Enum
    │   │   ├── Services/        # Event Services
    │   │
    │   ├── Spies/
    │   │   ├── Commands/        # Handles state-changing actions
    │   │   ├── Events/          # Handles Events for Spies Quables (spies-queue)
    │   │   ├── Http/            
    │   │   │   ├── Controllers/ # HTTP controllers
    │   │   │   └── Requests/    # Request validation
    │   │   ├── Models/          # Spy model and related business logic
    │   │   ├── Repositories/    # Spy repository
    │   │   ├── Services/        # Spy services
    │   
    database/
    ├── factories/            # Factories for generating dummy data
    ├── migrations/           # Database migrations
    ├── seeders/              # Seeders to populate initial data
    │
    routes/
    ├── api.php               # API routes

## Testing
### This project uses PestPHP for testing.
    Run all tests:
    ./vendor/bin/pest

## Seeder for testing:
### Via the command line

    php artisan tinker
    Spy::factory()->count(10)->create();

## API Documentation

After your project is installed, you can access it in a 
    
    POST /api/login endpoint

The api credentials are:

    email: api@test.com 
    password: 123456

the response gives you a token that you can use in the bearer token of your requests.

## API Endpoints

### All Requests need to be Authenticated 

### Create a new spy

#### POST /api/spy/store 
    Request Body:
    {
        "name": "test",
        "surname": "testSurname",
        "agency": "CIA",
        "country_of_operation": "GR",
        "birthday": "30-01-1991"
    }

### Fetch All Spies (Paginated)

#### GET /api/spies/all
    Query Parameters:
    
    name: Filter by name or surname
    age: Filter by exact or range (e.g., 25-35)

    Example:
        /api/spies/all?name=test
        /api/spies/all?surname=testSurname
        /api/spies/all?age=33
        /api/spies?age[min]=20&age[max]=30


### Get spies randomly with throttling to 10 request per minute

#### GET /api/spies/get

    Description: Fetch 5 random spies.
    Rate Limit: 10 requests per minute.


## Postman Collection
    included in the root of the project.
    
    SpyApp.postman_collection.json


## Notes to Improve
    1. Encyrpt sensitive data such as name/surname or agency
    2. Permissioning
    3. Advanced Filtering and Search
    4. Detailed Activity Logs / Enhanced Error Handling
    5. Add a cache layer for the spies to reduce the number of queries to the database.
    6. Indexing Database
    7. Add more Tests
