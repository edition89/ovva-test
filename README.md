# ovva-test
Test task for ovva

Start install project 

> git clone https://github.com/edition89/ovva-test.git  
> cd ovva-test  
composer install  
npm install  
cp .env.example .env  
php artisan key:generate

create database  
change the parameters in the .env such as: DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD and L5_SWAGGER_CONST_HOST

> php artisan migrate  
php artisan serve
