# Laravel - task manager web application
**Prerequisites:** 
* PHP 8
* MySql 8
* Laravel 11
* Composer 2
* npm 11

## Project Setup
####  Repository URL: https://github.com/amitshahc/task-manager.git 
**Branch: main**

1. Download / Clone the repository on local pc unzip it if required.
2. Place it under the `/www` folder is possible (not mandatory), or at any other folder
3. open command prompt and `cd <target folder>`
4. run `composer install`
5. copy `.env.example` to `.env`
6. run `php artisan key:generate`
7. open `.env` file and update below variables with provided database connection details
(considering the database and user has been created in MySQL)
	> DB_CONNECTION=mysql
	>DB_HOST=127.0.0.1
	>DB_PORT=3306
	>DB_DATABASE=task_manager
	>DB_USERNAME=task_manager
	>DB_PASSWORD=task_manager
8. run `php artisan migrate`
9. run `npm install`
10. run `npm run build`
11. run `php artisan db:seed` (optional)
12. run `php artisan serve`
13. open browser `http://localhost:8000`
14. login as user: `test@example.com` password: `test1234` (only if #11 been executed)
15. Or you can also register as new user with `Sign Up` link
16. Navigate to `Tasks` tab 
17. You can find and default project `My project` with empty task list
18. You can also find another project in dropdown with 5 seeded tasks (only if #11 been executed)
**All yours to test and report any bug also welcome !**
