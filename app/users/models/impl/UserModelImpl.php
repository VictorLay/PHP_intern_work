<?php


class UserModelImpl extends TransactionImpl implements UserModel
{

    private const CREATE_QUERY = "INSERT INTO my_db_test.users (`email`, `country`, `name`,`password`, `deleted`, `avatar_id`) VALUES ( :email , :country, :name, :password, false, 1);";
    private const SHOW_ALL_QUERY = "SELECT `id`, `email`, `country`, `role`, `name` FROM users JOIN user_role ON users.id = user_role.user_id JOIN roles ON user_role.role_id = roles.role_id  WHERE `deleted` = FALSE order by `user_id`;";
    private const SHOW_LIMITED_USERS_QUERY = "SELECT `id`, `email`, `country`, `role`, `name`, `picture_path` FROM users JOIN user_role ON users.id = user_role.user_id JOIN roles ON user_role.role_id = roles.role_id JOIN users_avatar ON users.avatar_id = users_avatar.avatar_id where `deleted` = false order by -`user_id`  LIMIT :user_count, :num_of_users";
    private const SHOW_USER_BY_MAIL_QUERY = "SELECT `id`, `email`, `country`, `role`, `name`, `password`, `picture_path` FROM users JOIN user_role ON users.id = user_role.user_id JOIN roles ON user_role.role_id = roles.role_id JOIN users_avatar ON users.avatar_id = users_avatar.avatar_id WHERE users.`email`=:email and `deleted` = FALSE;";
    private const SHOW_USER_BY_ID_QUERY = "SELECT `id`, `email`, `country`, `role`, `name`, `picture_path` FROM users JOIN user_role ON users.id = user_role.user_id JOIN roles ON user_role.role_id = roles.role_id JOIN users_avatar ON users.avatar_id = users_avatar.avatar_id WHERE users.`id`=:user_id and `deleted` = FALSE;";
    private const UPDATE_BY_ID_QUERY = "UPDATE `my_db_test`.`users` SET `email`=:email, `country`=:country, `name`=:name, `avatar_id`=:avatar_id WHERE `id`=:id and `deleted`=FALSE;";
    private const DELETE_BY_ID_QUERY = "UPDATE `my_db_test`.`users` SET `deleted`=TRUE  WHERE `id`=:id";
    private const COUNT_USERS_QUERY = "SELECT COUNT(*) FROM `users` where `deleted` = false;";
    private const CREATE_USER_ROLE_QUERY = "INSERT INTO `user_role` (`user_id`, `role_id`) VALUES (:user_id, :role_id)";



    /**
     * @param User $user
     * @return void
     * @throws ModelException
     */
    public function create(User $user): void
    {
        try {
            $statement = $this->connection->prepare(self::CREATE_QUERY);
            $statement->execute([
                ':email' => $user->getEmail(),
                ':country' => $user->getCountry(),
                ':name' => $user->getName(),
                ':password' => password_hash(1234, PASSWORD_DEFAULT)
            ]);
            $autoincrementUserId = $this->connection->lastInsertId();
            $roleId = PermissionCtrl::getRoleId($user->getRole());
            $statement = $this->connection->prepare(self::CREATE_USER_ROLE_QUERY);
            $statement->execute(
                [
                    ':user_id' => $autoincrementUserId,
                    ':role_id' => $roleId
                ]
            );

            $this->logger->log("user id = " . $autoincrementUserId, DEBUG_LEVEL);
        } catch (Exception $exception) {
            throw new ModelException($exception);
        }

    }

    /**
     * @param AuthorizationInfo $authorizationInfo
     * @return User|null
     */
    public function read(AuthorizationInfo $authorizationInfo): ?User
    {
        $statement = $this->connection->prepare(self::SHOW_USER_BY_MAIL_QUERY);
        $statement->execute([
            ":email" => $authorizationInfo->getMail(),
        ]);

        if ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $user = new User();

            $user->setId($row["id"]);
            $user->setEmail($row["email"]);
            $user->setCountry($row["country"]);
            $user->setName($row["name"]);
            $user->setRole($row["role"]);
            $user->setAvatarPath($row["picture_path"]);
            return password_verify($authorizationInfo->getPassword(), $row["password"]) ? $user : null;
        }
        $this->logger->log("The user with such mail doesn't exist.");
        return null;
    }

    /**
     * @param int $id
     * @return User
     * @throws ModelException
     */
    public function readById(int $id): User
    {

        $statement = $this->connection->prepare(self::SHOW_USER_BY_ID_QUERY);
        $statement->bindParam(":user_id", $id, PDO::PARAM_INT);
        $statement->execute();

        if ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $user = new User();

            $user->setId($row["id"]);
            $user->setEmail($row["email"]);
            $user->setCountry($row["country"]);
            $user->setName($row["name"]);
            $user->setRole($row["role"]);
            $user->setAvatarPath($row["picture_path"]);

            return $user;
        }
        $this->logger->log("The user with such mail doesn't exist.");
        throw new ModelException("The user with such mail doesn't exist.");
    }


    public function readAll(): array
    {
        $users = array();
        $statement = $this->connection->prepare(self::SHOW_ALL_QUERY);
        $statement->execute();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $user = new User();
            $user->setId($row["id"]);
            $user->setEmail($row["email"]);
            $user->setCountry($row["country"]);
            $user->setName($row["name"]);
            $user->setRole($row["role"]);
            $users[] = $user;
        }

        return $users;
    }

    public function readSeparately(int $page): array
    {

        /** @var int $lowerResult */
        /** @var int $upperResult */
        $userCount = ($page - 1) * NUM_OF_USERS_ON_ONE_PAGE;
        $numOfUsers = NUM_OF_USERS_ON_ONE_PAGE;
        $users = array();
        $statement = $this->connection->prepare(self::SHOW_LIMITED_USERS_QUERY);

        $statement->bindParam(":user_count", $userCount, PDO::PARAM_INT);
        $statement->bindParam(":num_of_users", $numOfUsers, PDO::PARAM_INT);

        $statement->execute();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $user = new User();
            $user->setId($row["id"]);
            $user->setEmail($row["email"]);
            $user->setCountry($row["country"]);
            $user->setName($row["name"]);
            $user->setRole($row["role"]);
            $user->setAvatarPath($row['picture_path']);
            $users[] = $user;
        }

        return $users;
    }

    public function countUsers(): int
    {
        $statement = $this->connection->prepare(self::COUNT_USERS_QUERY);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $this->logger->log($row["COUNT(*)"]);
        return $row["COUNT(*)"];
    }

    /**
     * @param User $newUser
     * @return void
     * @throws ModelException
     */
    public function update(User $newUser): void
    {
        try {
            $statement = $this->connection->prepare("SELECT `avatar_id` FROM `users_avatar` WHERE `picture_path` = :pic_path;");
            $statement->execute([
                ":pic_path" => $newUser->getAvatarPath()
            ]);
            if ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $avatarId = $row['avatar_id'];
            } else {
                $statement = $this->connection->prepare("INSERT INTO `my_db_test`.`users_avatar` (`picture_path`) VALUES (:pic_path)");
                $statement->execute([
                    ":pic_path" => $newUser->getAvatarPath()
                ]);
                $avatarId = $this->connection->lastInsertId();
            }

            $userRoleId = PermissionCtrl::getRoleId($newUser->getRole());
            $userId = $newUser->getId();
            $statement=$this->connection->prepare("UPDATE user_role SET `role_id`=:role_id WHERE `user_id` = :user_id");
            $statement->bindParam(":role_id", $userRoleId, PDO::PARAM_INT);
            $statement->bindParam(":user_id", $userId, PDO::PARAM_INT);
            $statement->execute();

            $statement = $this->connection->prepare(self::UPDATE_BY_ID_QUERY);
            $statement->execute([
                ':id' => $newUser->getId(),
                ':email' => $newUser->getEmail(),
                ':country' => $newUser->getCountry(),
                ':name' => $newUser->getName(),
                ":avatar_id" => $avatarId
            ]);
        } catch (Exception $exception) {
            $this->logger->log("Update was complete unsuccessfully! " . $exception, ERROR_LEVEL);
            throw new ModelException($exception);
        }
    }

    public function delete(int $id): void
    {
        $statement = $this->connection->prepare(self::DELETE_BY_ID_QUERY);
        $statement->execute([
            ':id' => $id
        ]);
    }

}