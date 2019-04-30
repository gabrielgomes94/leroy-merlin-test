## SETUP

PHP 7.2
MySQL
Redis

To run this project you can use Laradock: a set of Docker containers for Laravel environments.

1 - Clone Laradock inside your PHP project:
```
git clone https://github.com/Laradock/laradock.git
```
2 - Enter the laradock folder and rename env-example to .env.
```
cp env-example .env
```
3 - Run your containers:
```
docker-compose up -d nginx mysql phpmyadmin redis workspace
```
4 - Open your project’s .env file and set the following:
```
DB_HOST=mysql
REDIS_HOST=redis
QUEUE_HOST=beanstalkd
```
5 - Open your browser and visit localhost: http://localhost.

More details on: https://laradock.io/