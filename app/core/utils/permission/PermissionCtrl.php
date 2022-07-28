<?php

namespace app\core\utils\permission;

use app\users\entities\User;

class PermissionCtrl
{
    //todo replace with enum
    private array $accessedRoles;
    private int $userIdWithAccess;


    public function __construct()
    {
        $this->accessedRoles = array();
        $this->userIdWithAccess = -1;
    }


    /**
     * @param array $accessedRoles
     */
    protected function setAccessedRoles(array $accessedRoles): void
    {
        $this->accessedRoles = $accessedRoles;
    }


    protected function checkUserPermission(bool $setAccessWithId = false, string $userIndexInTheSession = 'user'): bool
    {
        if (!key_exists($userIndexInTheSession, $_SESSION)) {
            return false;
        }
        /** @var User $user */
        $user = $_SESSION["$userIndexInTheSession"];
        $userId = $user->getId();
        $userRole = $user->getRole();
        /** @var string $role */
        foreach ($this->accessedRoles as $role) {
            if ($userRole == $role) {
                return true;
            }
        }
        if ($setAccessWithId) {
            return $userId == $_POST['user_id'];
        }
        return false;
    }

    public static function getRoleId(string $role): ?int
    {
        return match ($role) {
            USER => 2,
            ADMIN => 1,
            default => null,
        };
    }

    public function checkPostKeys(array $arrayOfPostKeys): bool
    {
        $isAllKeysExist = true;
        foreach ($arrayOfPostKeys as $postKey) {
            $isAllKeysExist &= key_exists($postKey, $_POST);

        }
        return $isAllKeysExist;
    }
}