# Sunzinet Test Task - Szymon Osadowski

## Installation 
Clone repository

`git clone https://github.com/szosa/sunzinet.git` 

### API
Go to api directory

`cd api`

Download dependencies

`composer install`

Copy .env file 

`cp .env.example .env`

Edit .env file, set:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
```

Run migration

`php artisan migrate`

Set JWT secret token

`php artisan jwt:secret`

Run server 

`php artisan serve`

### Front app
Go to app dir

`cd ../app`

Download dependencies
 
`npm install`

Copy .env file

`cp .env.dist .env`

Run server

`npm run serve` 

Open in browser: http://localhost:8080/