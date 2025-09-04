<?php

namespace App\Utils;

use Slim\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class JsonResponse
{
    public static function from(array $data): ResponseInterface
    {
        //["dados" => $usuarios, "httpStatusCode" => 201]
        $statusCode = $data['httpStatusCode'] ?? 200;
        unset($data['httpStatusCode']);
        //["dados" => $usuarios]
        $response = new Response();
        $response->getBody()->write(json_encode($data));
        // {"dados" : [usuarios]}
        return $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
    }

    public static function ok (array $data): ResponseInterface
    {
        $response = new Response();
        $response -> getBody() -> write(json_encode($data));
        return $response -> withHeader('Content-Type', 'application/json') -> withStatus(200);
    }

    public static function created (array $data): ResponseInterface
    {
        $response = new Response();
        $response -> getBody() -> write(json_encode($data));
        return $response -> withHeader('Content-Type', 'application/json') -> withStatus(201);
    }

    public static function notFound (array $data): ResponseInterface
    {
        $response = new Response();
        $response -> getBody() -> write(json_encode($data));
        return $response -> withHeader('Content-Type', 'application/json') -> withStatus(404);
    }

    public static function badRequest (array $data): ResponseInterface
    {
        $response = new Response();
        $response -> getBody() -> write(json_encode($data));
        return $response -> withHeader('Content-Type', 'application/json') -> withStatus(400);
    }
}