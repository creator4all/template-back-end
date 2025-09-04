<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\UsuarioService;
use OpenApi\Annotations as OA;

class AuthController{

    private $service;

    public function __construct(UsuarioService $service){
        $this->service = $service;
    }

    public function register(Request $request, Response $response) {
        return $this->service->CadastrarUsuario($request->getParsedBody());
    }


    public function login(Request $request, Response $response): Response {
        return $this->service->login($request->getParsedBody());
    }
}