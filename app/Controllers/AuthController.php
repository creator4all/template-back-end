<?php

namespace App\Controllers;

use App\DTO\UsersDTO;
use App\Utils\JsonResponse;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\UsuarioService;
use OpenApi\Annotations as OA;

class AuthController{

    private UsuarioService $service;

    public function __construct(UsuarioService $service){
        $this->service = $service;
    }

    public function register(Request $request, Response $response) {

        $dto = new UsersDTO
        (
            $request->getParsedBody()['id'],
            $request->getParsedBody()['nome'],
            $request->getParsedBody()['email'],
            $request->getParsedBody()['senha']
        );
        return JsonResponse::from($this->service->CadastrarUsuario($dto));
    }

    public function login(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $dto = new UsersDTO
        (
            null,
            null,
            $body['email'],
            $body['senha']
        );
        return JsonResponse::from($this->service->login($dto));
    }
}