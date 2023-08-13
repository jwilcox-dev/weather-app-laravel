# EUA Weather Challenge - Back-End (Laravel)

##### Josh Wilcox

### Instructions

1. Clone Repository.
2. Enter the directory and run "composer install".
3. Rename ".env.example" to ".env".
4. Configure the values for DB_DATABASE, DB_USERNAME and DB_PASSWORD, as well as DB_PORT if required.
5. Run "php artisan key:generate".
6. Run "php artisan migrate".
7. Run "php artisan serve" (use default port 8000).
8. Use as back-end API in combination with React front-end.

### Misc Notes

*Built using Laravel v10.10 and PHP 8.1, with Laravel Sanctum to support API authentication processes, as well as MariaDB 10.4.24. As a Poc, Sanctum CORS is configured to allow from specific ports only, therefore, this API should run on port 8000, with the accompanying front-end React application running on port 5173.*
