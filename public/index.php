<?php
declare(strict_types=1);

use DI\Container;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);

$app = AppFactory::create();

$settings = require __DIR__ . '/../app/settings.php';
$settings($container);

$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($container);

$repositories = require __DIR__ . '/../app/repositories.php';
$repositories($container);

$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);

$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

$app->run();