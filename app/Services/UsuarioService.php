<?php
namespace App\Services;
use App\DTO\UsersDTO;
use App\Repositories\UsuarioRepository;
use Slim\Psr7\Response;

final class UsuarioService{
    private UsuarioRepository $UsuarioRepository;

    public function __construct(UsuarioRepository $UsuarioRepository){
        $this->UsuarioRepository = $UsuarioRepository;
    }
    public function CadastrarUsuario(UsersDTO $dto): array
    {
        if($this->UsuarioRepository->emailExiste($dto['email'])){
            throw new \Exception("Email já cadastrado");
        }

        $dto['senha'] = password_hash($dto['senha'], PASSWORD_DEFAULT);

        $user = $this->UsuarioRepository->criar($dto->toEntity());
        if($user){

            return ["dados" => UsersDTO::fromEntity($user)];

        } else {
            throw new \Exception("Erro ao registrar usuário");
        }
    }

    public function login(UsersDTO $dto)
    {
        $usuario = $this->UsuarioRepository->findByEmail($dto->toEntity());
        if(!$usuario || !password_verify($dto->getSenha(), $usuario->getSenha())){
            throw new \Exception("Email ou senha inválidos");
        }

        return ["dados" => UsersDTO::fromEntity($usuario)];
    }
}