<?php

class UserServiceImpl implements UserService
{
    private UserModel $userModel;
    private Logger $logger;

    public function __construct()
    {
        $this->userModel = ModelsFactory::getInstance()->getUserDao();
        $this->logger = Logger::getLogger();
    }


    public function isUserExist(AuthorizationInfo $authorizationInfo): bool
    {
        $user = $this->userModel->read($authorizationInfo);
        return !is_null($user);
    }

    public function showSeparately(int $page = 0): array
    {
        $users = $this->userModel->readSeparately($page);
        return $this->setExistingAvatarPath($users);
    }

    public function countUsers(): int
    {
        return $this->userModel->countUsers();
    }

    public function create(User $user): bool
    {
        $this->userModel->beginTransaction();
        try {

            if (UserValidator::isValid($user)) {
                $this->userModel->create($user);
            } else {
                $_SESSION['not_valid_user_data'] = $user;
                return false;
            }
            $this->userModel->commit();
            return true;
        } catch (ModelException $exception) {
            $this->userModel->rollback();
            $_SESSION['not_valid_user_data'] = $user;

            $this->logger->log("The new user wasn't been created. " . $exception, ERROR_LEVEL);
            $_SESSION['validator_response'] .= "Oupss... You couldn't to create user with such Email...";
            return false;
        }
    }

    public function update(User $user): bool
    {
        $this->userModel->beginTransaction();
        try {
            if (UserValidator::isValid($user)) {
                $this->userModel->update($user);
            } else {
                $_SESSION['not_valid_user_data'] = $user;
                return false;
            }
            $this->userModel->commit();
            return true;
        } catch (ModelException $exception) {
            $this->userModel->rollback();
            $this->logger->log("User wasn't updated!", ERROR_LEVEL);
            $_SESSION['not_valid_user_data'] = $user;
            $_SESSION['validator_response'] .= "Oupss... You couldn't to update user with such Email...";
            return false;
        }
    }

    public function showAll(): array
    {
        $users = $this->userModel->readAll();
        return $this->setExistingAvatarPath($users);
    }

    public function showUser(AuthorizationInfo $authorizationInfo): User
    {
        $users[0] = $this->userModel->read($authorizationInfo);
        /** @var User $user */
        $user = $this->setExistingAvatarPath($users)[0];
        return $user;

    }

    public function findUser(int $userId): ?User
    {
        try {
            $users[0] = $this->userModel->readById($userId);
            /** @var User $user */
            $user = $this->setExistingAvatarPath($users)[0];
            return $user;
        } catch (ModelException $exception) {
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
            $this->userModel->delete($userId);
        } else {
            throw new Exception("the attempt of deleting of yourself");
        }
    }

    private function setExistingAvatarPath(array $users): array
    {
        /** @var User $user */
        foreach ($users as $user) {
            $user->setAvatarPath($this->getExistingAvatarPath($user->getAvatarPath()));
        }
        return $users;
    }

    private function getExistingAvatarPath(string $path): string
    {
        if (file_exists($path)) {
            return $path;
        }
        return DEFAULT_AVATAR_PATH;
    }


}