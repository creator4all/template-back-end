<?php
declare(strict_types=1);

use DI\Container;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

use Illuminate\Database\Capsule\Manager as Capsule;


return function (Container $container) {
    $container->set(LoggerInterface::class, function (ContainerInterface $c) {
        $settings = $c->get('settings');

        $loggerSettings = $settings['logger'];
        $logger = new Logger($loggerSettings['name']);

        $processor = new UidProcessor();
        $logger->pushProcessor($processor);

        $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
        $logger->pushHandler($handler);

        return $logger;
    });

    $container->set(Capsule::class, function (ContainerInterface $c) {
        $settings = $c->get('settings')['db'];
        $capsule = new Capsule();
        $capsule->addConnection($settings['connections'][$settings['default']]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        return $capsule;
    });

    $container->set(\App\Repositories\UsuarioRepository::class, function () {
        return new \App\Repositories\UsuarioRepository();
    });

    $container->set(\App\Controllers\AuthController::class, function(ContainerInterface $c) {
        return new \App\Controllers\AuthController($c->get(\App\Services\UsuarioService::class));
    });

    $container->set(\App\Services\UsuarioService::class, function(ContainerInterface $c) {
        return new \App\Services\UsuarioService($c->get(\App\Repositories\UsuarioRepository::class));
    });

    // Initialize Eloquent
    $capsule = $container->get(Capsule::class);
};
