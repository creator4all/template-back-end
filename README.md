# API de Autenticação com Slim Framework 4

Este projeto é uma API RESTful de autenticação de usuários desenvolvida com o Slim Framework 4, utilizando conceitos modernos de desenvolvimento como arquitetura em camadas, validação de dados, e autenticação JWT.

## Visão Geral do Projeto

O projeto implementa um sistema de autenticação com funcionalidades de registro e login de usuários, seguindo boas práticas de desenvolvimento e arquitetura de software.

### Tecnologias Utilizadas

- **Slim Framework 4**: Framework PHP leve para desenvolvimento de APIs RESTful
- **PHP-DI**: Container de injeção de dependências
- **Illuminate/Database (Eloquent ORM)**: ORM para manipulação de banco de dados
- **Respect/Validation**: Biblioteca para validação de dados
- **Tuupola/Slim-JWT-Auth**: Middleware para autenticação JWT
- **Monolog**: Biblioteca para logging
- **Phinx**: Ferramenta para migrações de banco de dados
- **PHPUnit**: Framework para testes unitários

## Arquitetura do Projeto

O projeto segue uma arquitetura em camadas, separando responsabilidades entre:

- **Controllers**: Responsáveis por receber requisições e delegar para os serviços
- **Services**: Contêm a lógica de negócio da aplicação
- **Repositories**: Responsáveis pela comunicação com o banco de dados
- **Models**: Representam as entidades do banco de dados
- **Middleware**: Interceptam requisições para validação e tratamento de erros
- **Schemas**: Definem regras de validação para os dados de entrada

## Diagrama de Classes

```
+------------------------+       +------------------------+       +------------------------+
|   AuthController       |       |   UsuarioService      |       |   UsuarioRepository   |
+------------------------+       +------------------------+       +------------------------+
| - service: UsuarioSvc  |------>| - repository: UserRepo |------>| + emailExiste()        |
| + __construct()        |       | + __construct()        |       | + criar()              |
| + register()           |       | + CadastrarUsuario()   |       | + findByEmail()        |
| + login()              |       | + login()              |       +------------------------+
+------------------------+       +------------------------+                 |
                                                                           |
                                                                           v
+------------------------+       +------------------------+       +------------------------+
| ValidateSchemaMiddlew. |       |   UsersSchema         |       |   Users (Model)       |
+------------------------+       +------------------------+       +------------------------+
| - schema: callable     |------>| + rules()              |       | # table: 'usuarios'   |
| - crossFieldValidation |       | + rules_login()        |       | # fillable: []        |
| + __construct()        |       | + validateCrossFieldR. |       | # hidden: ['senha']   |
| + process()            |       | + getCustomMessages()  |       | + tokens()            |
+------------------------+       +------------------------+       +------------------------+
                                                                           ^
                                                                           |
                                                                           |
                                                                 +------------------------+
                                                                 |   Tokens (Model)      |
                                                                 +------------------------+
                                                                 | # table: 'tokens'     |
                                                                 | # fillable: []        |
                                                                 | # dates: []           |
                                                                 | + user()              |
                                                                 +------------------------+
```

## Endpoints da API

### Registro de Usuário
```
POST /api/register
```
Corpo da requisição:
```json
{
  "nome": "Nome do Usuário",
  "email": "usuario@exemplo.com",
  "senha": "senha123",
  "confirmar_senha": "senha123"
}
```

### Login
```
POST /api/login
```
Corpo da requisição:
```json
{
  "email": "usuario@exemplo.com",
  "senha": "senha123"
}
```

## Instalação e Configuração

### Requisitos
- PHP 7.1 ou superior
- Composer
- MySQL ou outro banco de dados compatível com Eloquent

### Passos para Instalação

1. Clone o repositório:
```bash
git clone [url-do-repositorio]
cd slim_laravel
```

2. Instale as dependências:
```bash
composer install
```

3. Configure o banco de dados no arquivo `config/settings.php`

4. Execute as migrações:
```bash
vendor/bin/phinx migrate
```

5. Inicie o servidor de desenvolvimento:
```bash
composer start
```
Ou use Docker:
```bash
docker-compose up -d
```

6. Acesse a API em `http://localhost:8080`

## Testes

Execute os testes com o comando:
```bash
composer test
```

## Estrutura de Diretórios

```
/app
  /Controllers      # Controladores da aplicação
  /Middleware       # Middlewares para processamento de requisições
  /Models           # Modelos Eloquent
  /Repositories     # Repositórios para acesso a dados
  /Schemas          # Esquemas de validação
  /Services         # Serviços com lógica de negócio
  dependencies.php  # Configuração de injeção de dependências
  middleware.php    # Configuração de middlewares globais
  repositories.php  # Configuração de repositórios
  routes.php        # Definição de rotas da API
  settings.php      # Configurações da aplicação
/config             # Arquivos de configuração
/db                 # Migrações e seeds
/logs               # Logs da aplicação
/public             # Ponto de entrada da aplicação
/tests              # Testes automatizados
```
