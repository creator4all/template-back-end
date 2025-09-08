<?php
namespace App\Repositories;
use App\Entities\UsersEntity;
use App\Models\Users;

class UsuarioRepository
{
    public function emailExiste(UsersEntity $entity): bool
    {
        return Users::where('email', $entity->getEmail())->exists();
    }

    public function criar(UsersEntity $entity): UsersEntity
    {
        $user = Users::create($entity->toArray());
        return UsersEntity::fromModel($user);
    }

    public function findByEmail(UsersEntity $entity): ?UsersEntity
    {
        $user = Users::where('email', $entity->getEmail())->first();
        return UsersEntity::fromModel($user);
    }

}