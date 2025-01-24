
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
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=task_manager
DB_PASSWORD=task_manager
```
9. run `php artisan migrate`
10. run `npm install`
11. run `npm run build`
12. run `php artisan db:seed` (optional)
13. run `php artisan serve`
14. open browser `http://localhost:8000`
15. login as user: `test@example.com` password: `test1234` (only if #11 been executed)
16. Or you can also register as new user with `Sign Up` link
17. Navigate to `Tasks` tab 
18. You can find and default project `My project` with empty task list
19. You can also find another project in dropdown with 5 seeded tasks (only if #11 been executed)
**All yours to test and report any bug also welcome !**

> [!Caution]
> Apologies for the poor drag JavaScript utility, it might be not so smooth, but just found it quickly to make it work. More efficient JavaScript can be integrated for better user-experience. Just try to bear with it for the testing.
> 
> My focus was on the Laravel coding and features. 

### My Notes
* I have user Laravel/Breeze for login utility scaffold
* I have created module and My code is in custom module under `Modules/Tasks`
* The model used are outside in original `/app` folder structure to keep it shared between modules
* Using repository design pattern without reflect/interface, but can use that too.
* Using breeze's css with tailwind, not much worked on css part
* Using breeze's blade components but also have made mine custom
* No SQL query written in the code
* I would recommend it to create this application as Laravel microservice with Restful API (back-end) and ReactJS (front-end) application. but not done due to time constrain. 
