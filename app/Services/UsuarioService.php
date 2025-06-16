<?php
namespace App\Services;
use App\Repositories\UsuarioRepository;

final class UsuarioService{
    private UsuarioRepository $UsuarioRepository;

    public function __construct(UsuarioRepository $UsuarioRepository){
        $this->UsuarioRepository = $UsuarioRepository;
    }
    public function CadastrarUsuario(array $dados){
        if($this->UsuarioRepository->emailExiste($dados['email'])){
            throw new \Exception("Email já cadastrado");
        }

        $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

        return $this->UsuarioRepository->criar($dados);
    }

    public function login(array $dados){
        $usuario = $this->UsuarioRepository->findByEmail($dados['email']);
        if(!$usuario || !password_verify($dados['senha'], $usuario->senha)){
            throw new \Exception("Email ou senha inválidos");
        }

        return $usuario;
    }
}