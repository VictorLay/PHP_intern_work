<?php

namespace app\users\services;


use app\users\entities\AuthorizationInfo;
use app\users\entities\User;

interface UserService
{
    public function isUserExist(AuthorizationInfo $authorizationInfo): bool;

    public function countUsers(): int;

    public function create(User $user): bool;

    public function update(User $user): bool;

    public function showAll(): array;

    public function showSeparately(int $page = 0): array;

    public function findUser(int $userId): ?User;

    public function showUser(AuthorizationInfo $authorizationInfo): User;

    public function delete(int $userId): void;

}