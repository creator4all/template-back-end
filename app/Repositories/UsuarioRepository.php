<?php
namespace App\Repositories;
use App\Models\Users;

class UsuarioRepository
{
    public function emailExiste(string $email): bool
    {
        return Users::where('email', $email)->exists();
    }

    public function criar(array $dados): Users
    {
        return Users::create($dados);
    }

    public function findByEmail(string $email): ?Users
    {
        return Users::where('email', $email)->first();
    }

}