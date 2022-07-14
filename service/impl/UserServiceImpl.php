<?php
require_once "./bean/User.php";
require_once "./service/UserService.php";
require_once "./dao/factory/FactoryDao.php";
require_once "./util/validation/impl/UserValidator.php";
require_once "./bean/info/AuthorizationInfo.php";
require_once "./util/logger/Logger.php";
require_once "./service/exception/ServiceException.php";
require_once "./util/Router.php";

class UserServiceImpl implements UserService
{
    private UserDao $userDao;
    private Logger $logger;

    public function __construct()
    {
        $this->userDao = FactoryDao::getInstance()->getUserDao();
        $this->logger = Logger::getLogger();
    }


    public function isUserExist(AuthorizationInfo $authorizationInfo): bool
    {
        $user = $this->userDao->read($authorizationInfo);
        return !is_null($user);
    }

    public function showSeparately(int $page = 0): array
    {
        return $this->userDao->readSeparately($page);
    }

    public function countUsers(): int
    {
        return $this->userDao->countUsers();
    }

    public function create(User $user): bool
    {
        $this->userDao->beginTransaction();
        try {

            if (UserValidator::isValid($user)) {
                $this->userDao->create($user);
            } else {
                $_SESSION['not_valid_user_data'] = $user;
                return false;
            }
            $this->userDao->commit();
            return true;
        } catch (DaoException $exception) {
            $this->userDao->rollback();
            $_SESSION['not_valid_user_data'] = $user;

            $this->logger->log("The new user wasn't been created. " . $exception, ERROR_LEVEL);
            $_SESSION['validator_response'] .= "Oupss... You couldn't to create user with such Email...";
            return false;
        }
    }

    public function update(User $user): bool
    {
        $this->userDao->beginTransaction();
        try {
            if (UserValidator::isValid($user)) {
                $this->userDao->update($user);
            } else {
                $_SESSION['not_valid_user_data'] = $user;
                return false;
            }
            $this->userDao->commit();
            return true;
        } catch (DaoException $exception) {
            $this->userDao->rollback();
            $this->logger->log("User wasn't updated!", ERROR_LEVEL);
            $_SESSION['not_valid_user_data'] = $user;
            $_SESSION['validator_response'] .= "Oupss... You couldn't to update user with such Email...";
            return false;
        }
    }

    public function showAll(): array
    {
        return $this->userDao->readAll();
    }

    public function showUser(AuthorizationInfo $authorizationInfo): User
    {
        return $this->userDao->read($authorizationInfo);
    }

    public function findUser(int $userId): ?User
    {
        try {
            return $this->userDao->readById($userId);
        } catch (DaoException $exception) {
            $this->logger->log($exception, DEBUG_LEVEL);
            return null;
        }
    }


    /**
     * @param int $userId
     * @return void
     * @throws Exception
     */
    public function delete(int $userId): void
    {
        /** @var User $user */
        $user = $_SESSION['user'];
        if ($user->getId() != $userId) {
            $this->userDao->delete($userId);
        } else {
            throw new Exception("the attempt of deleting of yourself");
        }
    }


}