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

#### Setup API

- Setup and API_KEY on .env file

##### Setup spreadsheet file
- Upload the spreadsheet to an online repository, like s3, in order to send it to the API.
- Sample URL: https://s3-sa-east-1.amazonaws.com/teste-leroy-merlin/products_teste_webdev_leroy.xlsx

#### Queue setup

- Install beanstalkd
```
# Debian / Ubuntu:
  sudo apt-get update
  sudo apt-get install beanstalkd
```

- Start beanstalkd if it isnt started:
```
  sudo service beanstalkd start
```

#### Run the application

- Start the local development server
```
php artisan serve
```

- Process the background jobs
```
php artisan queue:work
```

#### Environment variables

.env - Environment variables can be set in this file

#### Testing

- Create a database for tests with its name as specified on `phpunit.xml` file on line 32, which is setted as the following tag:
```
<server name="DB_DATABASE" value="leroy_merlin_test_testdb"/>
```

```
CREATE DATABASE leroy_merlin_test_testdb;
```

- Run PHPUnit:
```
vendor/bin/phpunit
```
