<?php

class PermissionCtrl
{
    //todo replace with enum
    public static function permissionCheck(string $role): bool
    {
        /** @var User $user */
        if (key_exists('user', $_SESSION)) {
            $user = $_SESSION['user'];

            switch ($user->getRole()) {
                case $role:
                    return true;
                case $role:
                    return true;
                default:
                    Router::redirect("error_pages/permission_error.html");
            }
        }
        Router::redirect("error_pages/permission_error.html");
    }

    public static function getRoleId(string $role): ?int
    {
        switch ($role) {
            case "user":
                return 2;
            case "admin":
                return 1;
            default:
                return null;
        }

    }
}