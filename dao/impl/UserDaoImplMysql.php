<?php
require_once "./dao/UserDao.php";
require_once "./bean/info/AuthorizationInfo.php";
require_once "./util/logger/Logger.php";
require_once "./dao/exception/DaoException.php";
require_once "./util/permission/PermissionCtrl.php";


class UserDaoImplMysql implements UserDao
{
    private PDO $connection;
    private Logger $logger;
    private const CREATE_QUERY = "INSERT INTO my_db_test.users (`email`, `country`, `name`,`password`, `deleted`, `avatar_id`) VALUES ( :email , :country, :name, :password, false, 1);";
    private const SHOW_ALL_QUERY = "SELECT `id`, `email`, `country`, `role`, `name` FROM users JOIN user_role ON users.id = user_role.user_id JOIN roles ON user_role.role_id = roles.role_id  WHERE `deleted` = FALSE order by `user_id`;";
    private const SHOW_LIMITED_QUERY = "SELECT `id`, `email`, `country`, `role`, `name` FROM users JOIN user_role ON users.id = user_role.user_idJOIN roles ON user_role.role_id = roles.role_id LIMIT :fromMin, :toMax  WHERE `deleted` = FALSE;";
    private const SHOW_USER_BY_MAIL_QUERY = "SELECT `id`, `email`, `country`, `role`, `name`, `password` FROM users JOIN user_role ON users.id = user_role.user_id JOIN roles ON user_role.role_id = roles.role_id WHERE `email`=:email and `deleted` = FALSE;";
    private const UPDATE_BY_ID_QUERY = "UPDATE `my_db_test`.`users` SET `email`=:email, `country`=:country, `name`=:name, `avatar_id`=:avatar_id WHERE `id`=:id and `deleted`=FALSE;";
//    private const DELETE_BY_ID_QUERY = "DELETE FROM `my_db_test`.`users` WHERE `id`=:id";
    private const DELETE_BY_ID_QUERY = "UPDATE `my_db_test`.`users` SET `deleted`=TRUE  WHERE `id`=:id";


    public function __construct()
    {
        $this->logger = Logger::getLogger();
        $this->connection = new PDO('mysql:host=localhost;dbname=my_db_test;charset=utf8', 'root', 'mynewpassword');
    }


    /**
     * @param User $user
     * @return void
     * @throws DaoException
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
            $statement = $this->connection->prepare("INSERT INTO `user_role` (`user_id`, `role_id`) VALUES (:user_id, :role_id)");
            $statement->execute(
                [
                    ':user_id' => $autoincrementUserId,
                    ':role_id' => $roleId
                ]
            );

            $this->logger->log("user id = " . $autoincrementUserId, DEBUG_LEVEL);
        } catch (Exception $exception) {
            throw new DaoException($exception);
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
            return password_verify($authorizationInfo->getPassword(), $row["password"]) ? $user : null;
        }
        $this->logger->log("The user with such mail doesn't exist.");
        return null;
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

        //todo ask Dmitry about execute with parameters
        /** @var int $lowerResult */
        /** @var int $upperResult */
        $lowerResult = ($page-1) * 5;
        $upperResult = 5;
        $users = array();
        $statement = $this->connection->prepare('SELECT `id`, `email`, `country`, `role`, `name`, `picture_path` FROM users 
    JOIN user_role ON users.id = user_role.user_id
    JOIN roles ON user_role.role_id = roles.role_id 
    JOIN users_avatar ON users.avatar_id = users_avatar.avatar_id                                            
                                                where `deleted` = 0 order by `user_id`  LIMIT '.$lowerResult.",".$upperResult." ;");
        $statement->execute(
//            [
//                /** @var int $lowerResult */
//                /** @var int $upperResult */
//            ]
        );

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
        $statement = $this->connection->prepare("SELECT COUNT(*) FROM `users` where `deleted` = false;");
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $this->logger->log($row["COUNT(*)"]);
        return $row["COUNT(*)"];

        // TODO: Implement countUse;rs() method.
    }


    public function update(User $newUser): void
    {
        $statement = $this->connection->prepare("SELECT `avatar_id` FROM `users_avatar` WHERE `picture_path` = :pic_path;");
        $statement->execute([
            ":pic_path"=>$newUser->getAvatarPath()
        ]);
        if($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $avatarId = $row['avatar_id'];
        }else {
            $statement = $this->connection->prepare("INSERT INTO `my_db_test`.`users_avatar` (`picture_path`) VALUES (:pic_path)");
            $statement->execute([
                ":pic_path" => $newUser->getAvatarPath()

            ]);
            $avatarId = $this->connection->lastInsertId();
        }
        $statement = $this->connection->prepare(self::UPDATE_BY_ID_QUERY);
        $statement->execute([
            ':id' => $newUser->getId(),
            ':email' => $newUser->getEmail(),
            ':country' => $newUser->getCountry(),
            ':name' => $newUser->getName(),
            ":avatar_id"=> $avatarId
        ]);
    }

    public function delete(int $id): void
    {
        $statement = $this->connection->prepare(self::DELETE_BY_ID_QUERY);
        $statement->execute([
            ':id' => $id
        ]);
    }

    public function beginTransaction(): void
    {
        $this->connection->beginTransaction();
    }

    public function commit(): void
    {
        $this->connection->commit();
    }

    public function rollback(): void
    {
        $this->connection->rollBack();
    }


}