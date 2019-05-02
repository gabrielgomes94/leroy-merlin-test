### Setup

PHP 7.2

MySQL

Redis

Composer


- Install all the dependencies using composer
```
composer install
```

- Copy the example env file and make the required configuration changes in the .env file

```
cp .env.example .env
```

- Generate a new application key
```
php artisan key:generate
```

- Run the database migrations (Set the database connection in .env before migrating, also create the database schema before)
```
php artisan migrate
```

- Start the local development server
```
php artisan serve
```

#### Environment variables

.env - Environment variables can be set in this file
