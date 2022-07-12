<?php
require_once "./controller/Command.php";
require_once "./bean/User.php";
require_once "./service/factory/FactoryService.php";
require_once "./util/permission/PermissionCtrl.php";

class UpdateUserCommand implements Command
{
    public function execute(): void
    {
        PermissionCtrl::permissionCheck("admin");


        $path = './resources/' . $_FILES['picture']['name'];
        if (@copy($_FILES['picture']['tmp_name'], $path))
            echo 'Загрузка удачна'; //not view
        else{
            Router::redirect("error_pages/incorrect_data.html");
        }


        $newUser = new User();

        $newUser->setId($_POST["user_id"]);
        $newUser->setEmail($_POST["user_email"]);
        $newUser->setCountry($_POST["user_country"]);
        $newUser->setName($_POST["user_name"]);
        $newUser->setRole($_POST["user_role"]);
        $newUser->setAvatarPath($path);


        FactoryService::getInstance()->getUserService()->update($newUser);
        Router::redirect();
    }

}