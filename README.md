## laravel version ^11.0 And PHP ^8.3

## run command 
<code>composer install</code>

## create .env file and copy .env.example variables

## env variable to set
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=url_shortner_rl
DB_USERNAME=root
DB_PASSWORD=

## Generate your application encryption key using :: 
   php artisan key:generate

## run : php artisan migrate

## run : php artisan db:seed

## super_admin credentials
   email : superadmin@gmail.com
   password : 1234
