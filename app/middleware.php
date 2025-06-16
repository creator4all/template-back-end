<?php
declare(strict_types=1);

use App\Application\Middleware\SessionMiddleware;
use Slim\App;
use Tuupola\Middleware\JwtAuthentication;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Users;

return function (App $app) {
    $container = $app->getContainer();
    $settings = $container->get('settings');

    $app->add(new JwtAuthentication([
        "path" => ["/perfil"], // rotas protegidas
        "ignore" => ["/login", "/register"],
        "secret" => $settings['jwt']['secret'],
        "attribute" => "token",
        "error" => function (Response $response, array $arguments) {
            $data = ["error" => "Token inválido ou ausente"];
            $response->getBody()->write(json_encode($data));
            return $response->withHeader("Content-Type", "application/json")->withStatus(401);
        },
        "before" => function (Request $request, $arguments) use ($container) {
            // Decodifica o token e busca o usuário
            $token = $request->getAttribute("token");

            $jwtSecret = $container->get('settings')['jwt']['secret'];
            $decoded = \Firebase\JWT\JWT::decode($token['token'], new \Firebase\JWT\Key($jwtSecret, 'HS256'));

            $userId = $decoded->sub ?? null;
            $user = $userId ? Users::find($userId) : null;

            // Coloca o usuário como atributo da request
            return $request->withAttribute('user', $user);
        },
    ]));
};
