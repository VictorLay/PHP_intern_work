<?php
require_once "./controller/Command.php";
require_once "./bean/User.php";
require_once "./service/factory/FactoryService.php";
require_once "./util/permission/PermissionCtrl.php";

class CreateCommand implements Command
{
    public function execute(): void
    {
        PermissionCtrl::permissionCheck('admin');
        $user = new User();

        $user->setEmail($_POST["user_email"]);
        $user->setCountry($_POST["user_country"]);
        $user->setName($_POST["user_name"]);
        $user->setRole('user');
        $user->setAvatarPath("./resources/default_avatar.jpg");

        FactoryService::getInstance()->getUserService()->create($user);
        header("location:http://localhost/");
        exit();
    }
}