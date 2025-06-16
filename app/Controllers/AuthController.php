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
    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Autenticação"},
     *     summary="Registra um novo usuário",
     *     description="Endpoint para cadastrar um novo usuário no sistema",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados do usuário",
     *         @OA\JsonContent(
     *             required={"nome", "email", "senha", "confirmar_senha"},
     *             @OA\Property(property="nome", type="string", example="Nome do Usuário"),
     *             @OA\Property(property="email", type="string", format="email", example="usuario@exemplo.com"),
     *             @OA\Property(property="senha", type="string", format="password", example="senha123"),
     *             @OA\Property(property="confirmar_senha", type="string", format="password", example="senha123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário registrado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Dados inválidos"
     *     )
     * )
     */
    public function register(Request $request, Response $response) {
        return $this->service->CadastrarUsuario($request->getParsedBody());
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Autenticação"},
     *     summary="Autentica um usuário",
     *     description="Endpoint para autenticação de usuários",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Credenciais do usuário",
     *         @OA\JsonContent(
     *             required={"email", "senha"},
     *             @OA\Property(property="email", type="string", format="email", example="usuario@exemplo.com"),
     *             @OA\Property(property="senha", type="string", format="password", example="senha123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login realizado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas"
     *     )
     * )
     */
    public function login(Request $request, Response $response): Response {
        return $this->service->login($request->getParsedBody());
    }
}