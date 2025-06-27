
# Laravel - Product list web application
**Prerequisites:** 
* PHP 8
* MySql 8
* Laravel 11
* Composer 2
* npm 11

## Project Setup
####  Repository URL: https://github.com/amitshahc/task-manager.git 
**Branch: feature/round2**

1. Download / Clone the repository on local pc unzip it if required.
2. Place it under the `/www` folder is possible (not mandatory), or at any other folder
3. open command prompt and `cd <target folder>`
4. run `composer install`
5. copy `.env.example` to `.env`
6. run `php artisan key:generate`
7. open `.env` file and update below variables with provided database connection details
(considering the database and user has been created in MySQL)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=task_manager
DB_PASSWORD=task_manager
```
9. run `php artisan migrate` (optional)
10. run `npm install` (optional)
11. run `npm run build` (optional)
# 12. run `php artisan db:seed` (optional)
13. run `php artisan serve`
14. open browser `http://localhost:8000/products`

