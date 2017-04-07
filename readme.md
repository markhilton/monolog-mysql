## Laravel Monolog MySQL Handler.

MySQL driver for Laravel Monolog.

### Installation

~~~
composer require markhilton/monolog-mysql
~~~

You'll then need to run `composer install` to download it and have the autoloader updated.

Open up `config/app.php` and find the `providers` key.

~~~
'providers' => array(
    // ...
    'Logger\Laravel\Provider\MonologMysqlHandlerServiceProvider'
);
~~~

Publish config using artisan CLI.

~~~
php artisan config:publish markhilton/monolog-mysql
~~~

Migrate tables.

~~~
php artisan migrate
~~~

## Usage

~~~php
Log::getMonolog()->pushHandler(new Logger\Monolog\Handler\MysqlHandler());
~~~

Or in `bootstrap/app.php`:

~~~php
$app->configureMonologUsing(function($monolog) use($app) {
    $monolog->pushHandler(new Logger\Monolog\Handler\MysqlHandler());
});
~~~

## Credits

Based on:

- [Pedro Fornaza] (https://github.com/pedrofornaza/monolog-mysql)
