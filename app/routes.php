<?php
declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\SwaggerController;
use App\Middleware\ValidateSchemaMiddleware;
use App\Schemas\UsersSchema;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $container = $app->getContainer();
    
    // Rotas de documentação Swagger
    $app->get('/docs', SwaggerController::class . ':ui');
    
    $app->group('/api', function (Group $group) use ($container) {
        // Rota para documentação OpenAPI JSON
        $group->get('/documentation', SwaggerController::class . ':documentation');
        
        // Rotas de autenticação
        $group->post('/register', AuthController::class . ':register')
            ->add(new ValidateSchemaMiddleware(
                [UsersSchema::class, 'rules'],
                [UsersSchema::class, 'validateCrossFieldRules']
            ));
        $group->post('/login', AuthController::class . ':login')
            ->add(new ValidateSchemaMiddleware([UsersSchema::class, 'rules_login']));
    })->add(new \App\Middleware\ErrorMiddleware());
};
