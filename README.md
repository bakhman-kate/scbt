# Тестовое задание

## КОНФИГУРАЦИЯ
1. PHP 7.4
2. Laravel 6

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

## ПРИМЕРЫ ВЫЗОВА API

curl -X GET -H "Content-Type: application/json" http://scbt.local/ping | json_pp

{
"code" : 20000,
"data" : {
"message" : "Сервис работает"
},
"error_message" : "",
"request_id" : "c7647b4d-2385-4582-a6f1-44b5a1d13f44",
"status" : "success"
}

curl -X GET -H "Content-Type: application/json" -H "x-api-token: 4412a75db2ca0a2247f291d68c3da19f" http://scbt.local/user/info | json_pp

{
"code" : 20000,
"data" : {
"bd" : "2022-04-08 13:58:06",
"date" : "2022-04-08 13:58:06",
"fio" : "Streich ADMIN",
"is_active" : true
},
"error_message" : "",
"request_id" : "e0faa218-b756-4072-923d-16f116da14ef",
"status" : "success"
}

curl -X PUT -H "Content-Type: application/json" -H "x-api-token: 4412a75db2ca0a2247f291d68c3da19f" http://scbt.local/user/info | json_pp

{
"code" : 40004,
"error_message" : "Вызываемый метод не поддерживается",
"request_id" : "21adab03-00c1-462a-8e41-abe9c65d6388",
"status" : "error"
}

curl -X POST --data '{"last_name": "Petrov", "name": "Petr", "bd": "2000-01-01 01:00:00"}' -H "Content-Type: application/json" -H "x-api-token: 4412a75db2ca0a2247f291d68c3da19f" http://scbt.local/user/create | json_pp

{
"code" : 20000,
"data" : {
"message" : "Пользователь успешно создан"
},
"error_message" : "",
"request_id" : "c89bf6a9-12ad-4a67-b80a-9ee221c7354c",
"status" : "success"
}