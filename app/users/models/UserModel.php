<?php

namespace app\users\models;

use app\core\exceptions\ModelException;
use app\users\entities\User;
use app\users\entities\AuthorizationInfo;

interface UserModel
{

    public function countUsers(): int;

    /** @throws ModelException */
    public function create(User $user): void;

    public function readAll(): array;

    public function readSeparately(int $quantity): array;

    public function read(AuthorizationInfo $authorizationInfo): ?User;

    /**
     * @param User $newUser
     * @return void
     * @throws ModelException
     */
    public function update(User $newUser): void;

    public function delete(int $id): void;

    /**
     * @param int $id
     * @return User
     * @throws ModelException
     */
    public function readById(int $id):User;

}