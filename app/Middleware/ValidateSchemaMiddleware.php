<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Slim\Psr7\Response;

class ValidateSchemaMiddleware implements MiddlewareInterface
{
    private $schema;
    private $crossFieldValidation;

    public function __construct(callable $schema, callable $crossFieldValidation = null)
    {
        $this->schema = $schema;
        $this->crossFieldValidation = $crossFieldValidation;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $data = $request->getParsedBody();
        $rules = call_user_func($this->schema, $data);

        $errors = [];

        foreach ($rules as $field => $rule) {
            try{
                $rule->assert($data[$field] ?? null);
            }catch (NestedValidationException $e){
                $errors[$field] = $e->getMessages();
            }
        }

        // Validação entre campos (se existir)
        if ($this->crossFieldValidation !== null && empty($errors)) {
            $crossFieldErrors = call_user_func($this->crossFieldValidation, $data);
            if (!empty($crossFieldErrors)) {
                $errors = array_merge($errors, $crossFieldErrors);
            }
        }

        if($errors){
            $response = new Response();
            $response->getBody()->write(json_encode([
                'status' => 'erro',
                'mensagem' => 'Dados inválidos',
                'erros' => $errors
            ], JSON_UNESCAPED_UNICODE));
            return $response->withStatus(422)->withHeader('Content-Type', 'application/json');
        }

        return $handler->handle($request);
    }
}