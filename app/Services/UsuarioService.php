<?php
namespace App\Services;
use App\Repositories\UsuarioRepository;
use Slim\Psr7\Response;

final class UsuarioService{
    private UsuarioRepository $UsuarioRepository;

    public function __construct(UsuarioRepository $UsuarioRepository){
        $this->UsuarioRepository = $UsuarioRepository;
    }
    public function CadastrarUsuario(array $dados): Response
    {
        if($this->UsuarioRepository->emailExiste($dados['email'])){
            throw new \Exception("Email já cadastrado");
        }

        $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

        if($this->UsuarioRepository->criar($dados)){
            $response = new Response();
            $response->getBody()->write(json_encode([
                'status' => 'sucesso',
                'mensagem' => 'Usuário registrado com sucesso'
            ]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        } else {
            throw new \Exception("Erro ao registrar usuário");
        }
    }

    public function login(array $dados){
        $usuario = $this->UsuarioRepository->findByEmail($dados['email']);
        if(!$usuario || !password_verify($dados['senha'], $usuario->senha)){
            throw new \Exception("Email ou senha inválidos");
        }

        return $usuario;
    }
}