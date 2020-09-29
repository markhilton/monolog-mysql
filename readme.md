## Laravel Monolog MySQL Handler.

This package will log errors into MySQL database instead storage/log/laravel.log file.

### Installation

~~~
composer require markhilton/monolog-mysql
~~~

Open up `config/app.php` and find the `providers` key.

~~~
'providers' => array(
    // ...
    Logger\Laravel\Provider\MonologMysqlHandlerServiceProvider::class,
);
~~~

Publish config using Laravel Artisan CLI.

~~~
php artisan vendor:publish
~~~

Migrate tables - you may want to [configure enviornment](#environment-configuration) beforehand.

~~~
php artisan migrate
~~~

## Application Integration

In your application `config/logging.php` add:

~~~php
use Logger\Monolog\Handler\MysqlHandler;

// ...

'channels' => [
    // ...
    'mysql' => [
        'driver' => 'monolog',
        'handler' => MysqlHandler::class,
        'level' => 'debug',
    ],
];
~~~

## Environment configuration

If you wish to change default table name to write the log into or database connection use following definitions in your .env file

~~~
DB_LOG_TABLE=logs
DB_LOG_CONNECTION=mysql
~~~

## Credits

Based on:

- [Pedro Fornaza] (https://github.com/pedrofornaza/monolog-mysql)
