<?php
require_once "./bean/User.php";
require_once "./bean/info/AuthorizationInfo.php";
require_once "./dao/Transaction.php";

interface UserDao extends Transaction
{

    public function countUsers(): int;

    /** @throws DaoException */
    public function create(User $user): void;

    public function readAll(): array;

    public function readSeparately(int $quantity): array;

    public function read(AuthorizationInfo $authorizationInfo): ?User;

    public function update(User $newUser): void;

    public function delete(int $id): void;


}