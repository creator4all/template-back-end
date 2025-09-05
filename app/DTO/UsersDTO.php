<?php

namespace App\DTO\UsersDTO;

use App\DTO\UsersDTO;
use App\Entities\UsersEntity;


class CidadesDTO
{
    private string $nome;
    private string $email;
    private string $senha;


    public function __construct(string $nome, string $email, string $senha)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
    }

    public function toEntity(): UsersEntity
    {
            return new UsersEntity
            (
                $this->nome,
                $this->email,
                $this->senha
            );
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSenha(): string
    {
        return $this->senha;
    }

    public function setSenha(string $senha): void
    {
        $this->senha = $senha;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

}