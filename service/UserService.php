<?php
require_once "./bean/info/AuthorizationInfo.php";
require_once "./bean/User.php";

interface UserService
{
    public function isUserExist(AuthorizationInfo $authorizationInfo): bool;

    public function countUsers(): int;

    /**
     * @param User $user
     * @return void
     * @throws ServiceException
     */
    public function create(User $user): void;

    public function update(User $user): void;

    public function showAll(): array;

    public function showSeparately(int $page = 0): array;

    public function showUser(AuthorizationInfo $authorizationInfo): User;

    public function delete(int $userId): void;

}