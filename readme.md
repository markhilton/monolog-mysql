## Laravel Monolog MySQL Handler.

This package will log errors into MySQL database instead storage/log/laravel.log file.

### Installation

```sh
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

```sh
php artisan vendor:publish
```

Migrate tables - you may want to [configure enviornment](#environment-configuration) beforehand.

```sh
php artisan migrate
```

## Application Integration

In your application `config/logging.php` add:

```php
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
```

# Application Integration (Laravel >= 5.6)

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

```env
DB_LOG_TABLE=logs
DB_LOG_CONNECTION=mysql
```

## Credits

Based on:

- [Pedro Fornaza] (https://github.com/pedrofornaza/monolog-mysql)
