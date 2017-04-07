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
    Logger\Laravel\Provider\MonologMysqlHandlerServiceProvider::class,
);
~~~

Publish config using Laravel Artisan CLI.

~~~
php artisan vendor:publish
~~~

Migrate tables.

~~~
php artisan migrate
~~~

## Usage

In your application `bootstrap/app.php` add:

~~~php
$app->configureMonologUsing(function($monolog) use($app) {
    $monolog->pushHandler(new Logger\Monolog\Handler\MysqlHandler());
});
~~~

## Credits

Based on:

- [Pedro Fornaza] (https://github.com/pedrofornaza/monolog-mysql)
