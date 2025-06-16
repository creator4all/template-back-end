<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="API de Autenticação Slim Framework",
 *     description="API RESTful para autenticação de usuários",
 *     @OA\Contact(
 *         email="contato@exemplo.com",
 *         name="Suporte API"
 *     )
 * )
 * 
 * @OA\Server(
 *     url="/",
 *     description="Servidor de Desenvolvimento"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */

/**
 * @OA\Tag(
 *     name="Autenticação",
 *     description="Endpoints para autenticação de usuários"
 * )
 */
