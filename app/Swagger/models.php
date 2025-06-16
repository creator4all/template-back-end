<?php

namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="Usuario",
 *     required={"nome", "email"},
 *     @OA\Property(property="id", type="integer", format="int64", description="ID do usuário"),
 *     @OA\Property(property="nome", type="string", description="Nome do usuário"),
 *     @OA\Property(property="email", type="string", format="email", description="Email do usuário"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Data de criação"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Data de atualização")
 * )
 */
class Usuario {}

/**
 * @OA\Schema(
 *     schema="Token",
 *     @OA\Property(property="id", type="integer", format="int64", description="ID do token"),
 *     @OA\Property(property="usuario_id", type="integer", format="int64", description="ID do usuário"),
 *     @OA\Property(property="token", type="string", description="Token JWT"),
 *     @OA\Property(property="expiration_time", type="string", format="date-time", description="Data de expiração"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Data de criação"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Data de atualização")
 * )
 */
class Token {}

/**
 * @OA\Schema(
 *     schema="Error",
 *     @OA\Property(property="status", type="string", example="erro"),
 *     @OA\Property(property="mensagem", type="string", example="Descrição do erro"),
 *     @OA\Property(
 *         property="erros",
 *         type="object",
 *         @OA\AdditionalProperties(
 *             type="array",
 *             @OA\Items(type="string")
 *         )
 *     )
 * )
 */
class Error {}
