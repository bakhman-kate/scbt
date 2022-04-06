# Тестовое задание

## КОНФИГУРАЦИЯ
1. PHP 7.4
2. Laravel 8

## УСТАНОВКА
1. git clone https://github.com/bakhman-kate/scbt.git
2. cd scbt
3. создаем файл .env на базе .env.example
4. docker-compose up --build -d
5. cd public
6. создаем файл .env на базе .env.example
7. docker-compose exec workspace bash
8. composer install
9. php artisan key:generate
10. php artisan migrate
11. php artisan db:seed