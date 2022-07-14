<?php
require_once "./bean/User.php";
require_once "./resources/conf_const.php";

class PermissionCtrl
{
    //todo replace with enum
    private array $accessedRoles;


    public function __construct()
    {
        $this->accessedRoles = array();
    }


    /**
     * @param array $accessedRoles
     */
    protected function setAccessedRoles(array $accessedRoles): void
    {
        $this->accessedRoles = $accessedRoles;
    }


    protected function checkUserPermission(string $userIndexInTheSession = 'user'):bool{
        if (key_exists($userIndexInTheSession, $_SESSION)){
            /** @var User $user */
            $user = $_SESSION["$userIndexInTheSession"];
            $userRole = $user->getRole();
            /** @var string $role */
            foreach ($this->accessedRoles as $role){
                if ($userRole == $role){
                    return true;
                }
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

    public function checkPostKeys(array $arrayOfPostKeys):bool{
        $isAllKeysExist = true;
        foreach ($arrayOfPostKeys as $postKey) {
            $isAllKeysExist &= key_exists($postKey, $_POST);
        }
        return $isAllKeysExist;
    }
}