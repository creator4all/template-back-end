<?php

namespace App\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Throwable;

class ErrorMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): \Psr\Http\Message\ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (Throwable $e) {
            $response = new Response();
            $response->getBody()->write(json_encode([
                'status' => 'erro',
                'mensagem' => $e->getMessage()
            ]));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
    }

}