<?php

namespace App\Schemas;

use Respect\Validation\Validator as v;

class UsersSchema
{
    public static function rules(): array
    {
        return [
            'nome' => v::stringType()->notEmpty()->setName('Nome'),
            'email' => v::email()->stringType()->notEmpty()->setName('E-mail'),
            'senha' => v::stringType()->notEmpty()->length(6, 255)->setName('Senha'),
            'confirmar_senha' => v::stringType()->notEmpty()->length(6, 255)->setName('Confirmação de senha'),
        ];
    }
    
    public static function rules_login(): array
    {
        return [
            'email' => v::email()->stringType()->notEmpty()->setName('E-mail'),
            'senha' => v::stringType()->notEmpty()->length(6, 255)->setName('Senha'),
        ];
    }

    /**
     * Validações adicionais que dependem de múltiplos campos
     * 
     * @param array $data Dados do formulário
     * @return array Erros de validação
     */
    public static function validateCrossFieldRules(array $data): array
    {
        $errors = [];
        
        // Validar se a confirmação de senha é igual à senha
        if (isset($data['senha'], $data['confirmar_senha']) && $data['senha'] !== $data['confirmar_senha']) {
            $errors['confirmar_senha'] = ['Confirmação de senha deve ser igual à senha informada'];
        }
        
        return $errors;
    }
    
    /**
     * Retorna mensagens personalizadas em português para as validações
     * 
     * @return array
     */
    public static function getCustomMessages(): array
    {
        return [
            'stringType' => '{{name}} deve ser uma string',
            'notEmpty' => '{{name}} não pode estar vazio',
            'email' => '{{name}} deve ser um endereço de e-mail válido',
            'length' => '{{name}} deve ter entre {{minValue}} e {{maxValue}} caracteres',
        ];
    }
}