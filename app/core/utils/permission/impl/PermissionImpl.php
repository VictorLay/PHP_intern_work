<?php

class PermissionImpl
{
    private array $accessedRoles;
    private int $accessedId;


    /**
     * @param array $accessedRoles
     */
    protected function setAccessedRoles(array $accessedRoles): void
    {
        $this->accessedRoles = $accessedRoles;
    }


    protected function checkUserPermission(string $userIndexInTheSession = 'user'): bool
    {
        if (!key_exists($userIndexInTheSession, $_SESSION)) {
            return false;
        }

        /** @var User $user */
        $user = $_SESSION["$userIndexInTheSession"];
        $userRole = $user->getRole();

        /** @var string $role */
        foreach ($this->accessedRoles as $role) {
            if ($userRole == $role) {
                return true;
            }
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
    public function checkGetKeys(array $arrayOfPostKeys): bool
    {
        $isAllKeysExist = true;
        foreach ($arrayOfPostKeys as $postKey) {
            $isAllKeysExist &= key_exists($postKey, $_GET);

        }
        return $isAllKeysExist;
    }
}