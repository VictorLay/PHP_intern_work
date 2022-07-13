<?php
require_once "./resources/conf_const.php";
require_once "./controller/Command.php";
require_once "./util/permission/PermissionCtrl.php";

class SignOutCommand extends PermissionCtrl implements Command
{

    public function __construct()
    {
        $this->setAccessedRoles([USER,ADMIN]);
    }

    public function execute(): void
    {
        if($this->checkUserPermission()){
            if (isset($_SESSION['user'])) {
                unset($_SESSION['user']);
            }
        }
        header('Location: http://localhost/');
        exit();
    }

}