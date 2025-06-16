<?php
declare(strict_types=1);

use DI\Container;
use Monolog\Logger;

return function (Container $container) {
    // Global Settings Object
    $container->set('settings', [
            'displayErrorDetails' => true, // Should be set to false in production
            'logger' => [
                'name' => 'slim-app',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
            'db' => [
                'default' => 'mysql',
                'connections' => [
                    'mysql' => [
                        'driver' => 'mysql',
                        'host' => getenv('DB_HOST') ?: 'mysql', // docker service name
                        'port' => getenv('DB_PORT') ?: '3306',
                        'database' => getenv('DB_DATABASE') ?: 'slim_laravel_dev',
                        'username' => getenv('DB_USERNAME') ?: 'root',
                        'password' => getenv('DB_PASSWORD') ?: 'secret',
                        'charset' => 'utf8mb4',
                        'collation' => 'utf8mb4_unicode_ci',
                        'prefix' => '',
                        'strict' => true,
                        'engine' => null,
                    ],
                ],
            ],
            'jwt' => [
                'secret' => 'supersecret',
            ],
    ]);
};
