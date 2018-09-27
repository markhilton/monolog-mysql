## Laravel Monolog MySQL Handler.

This package will log errors into MySQL database instead storage/log/laravel.log file.

### Installation

```bash
composer require markhilton/monolog-mysql
```

Open up `config/app.php` and find the `providers` key.

```php
'providers' => array(
    // ...
    Logger\Laravel\Provider\MonologMysqlHandlerServiceProvider::class,
);
```

Publish config using Laravel Artisan CLI.

```bash
php artisan vendor:publish
```

Migrate tables.

```bash
php artisan migrate
```

## Application Integration (Laravel >= 5.5)

In your application `bootstrap/app.php` add:

```php
$app->configureMonologUsing(function($monolog) use($app) {
    $monolog->pushHandler(new Logger\Monolog\Handler\MysqlHandler());
});
```

## Application Integration (Laravel <= 5.6)

In your application `config/logging.php` add:

```php
<?php
    // [...]

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['mysql'],
        ],

        // [...]

        'mysql' => [
            'driver' => 'custom',
            'via' => App\Logging\CreateMySQLLogger::class,
        ],
    ],
```

In your application `app/Logging/CreateMySQLLogger.php` add:

```php
<?php
namespace App\Logging;

use Exception;
use Monolog\Logger;
use Logger\Monolog\Handler\MysqlHandler;

class CreateMySQLLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array $config
     * @return Logger
     * @throws Exception
     */
    public function __invoke(array $config)
    {
        $channel = $config['name'] ?? env('APP_ENV');
        $monolog = new Logger($channel);
        $monolog->pushHandler(new MysqlHandler());
        return $monolog;
    }
}
```

## Environment configuration

If you wish to change default table name to write the log into or database connection use following definitions in your .env file

~~~
DB_LOG_TABLE=logs
DB_LOG_CONNECTION=mysql
~~~

## Credits

Based on:

- [Pedro Fornaza] (https://github.com/pedrofornaza/monolog-mysql)
