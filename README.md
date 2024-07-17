<p align="center">Laravel Blog API</p>

## About This Project

This is a Laravel project that implements a blog API with endpoints for managing blogs, posts, likes, and comments. The API is secured with a token middleware and uses the Laravel Like package for managing likes.

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL or any other supported database

## Installation
1. Clone the repository: 
    git clone https://github.com/legendoscar/LaravelBlogAPI.git
    cd LaravelBlogAPI

2. Install the dependencies:
    composer install

3. Copy the .env.example file to .env and configure your database and other environment settings:
    cp .env.example .env

4. Generate the application key:
    php artisan key:generate

5. Run the database migrations and seeders:
    php artisan migrate --seed

6. Serve the application:
    php artisan serve --port=1600


## API Endpoints
The API documentation is available on Postman:

**[Postman API Documentation](https://documenter.getpostman.com/view/6959988/2sA3kRL4sW)**


## Token Middleware
All routes are guarded by a token middleware. The value of the token from the request header should be vg@123. To use this in Postman:

1. Open Postman and create a new request.
2. Select the request method (GET, POST, etc.) and enter the URL for your API endpoint.
3. Go to the "Headers" tab.
4. Add a new header with the key Authorization and the value vg@123.
5. Send the request.


## Project Structure

The project follows the Laravel MVC pattern. Below are the key directories and files:
- app/Http/Controllers: Contains the controllers for handling API requests.
- app/Models: Contains the models for the application.
- app/Http/Middleware: Contains the token middleware.
- database/migrations: Contains the database migrations.
- routes/api.php: Contains the API routes.

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

## Contributing

If you wish to contribute to the project, feel free to open a pull request on the [GitHub repository](https://github.com/legendoscar/LaravelBlogAPI.git).


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
