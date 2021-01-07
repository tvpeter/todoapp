# Todo API Application

This is a simple todo API application written with laravel. It allows a user to register and manage his tasks on the app.

## Steps to install the application

- run `git clone` or pull the application
- open the project in your editor and create a new database (mysql or sqlite)
- Rename the `.env.example` to `.env`
- replace the `todo` in on the line DB_DATABASE to your database name
- replace `YOURPASSWORD` with your database password
- in the project's root directory, run the command `composer install` to install all the packages
- run the command `php artisan migrate:fresh --seed` to migrate and seed the database with dummy data
- run `php artisan serve` to start a local server
- Use postman to access the endpoints contained in the postman collection [here](https://www.getpostman.com/collections/1c16919b0bae1cdd9644) or download the file [here](https://github.com/tvpeter/todoapp/blob/master/TodoApp.postman_collection.json) and import to your postman


## Documentation

The API is documented using postman.

The collection is found [here](https://www.getpostman.com/collections/1c16919b0bae1cdd9644) or downloaded from the repo [here](https://github.com/tvpeter/todoapp/blob/master/TodoApp.postman_collection.json)

Your contributions are highly welcome.
    Thank you.