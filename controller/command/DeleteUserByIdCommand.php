<?php
require_once "./controller/Command.php";
require_once "./bean/User.php";
require_once "./service/factory/FactoryService.php";
require_once "./util/Router.php";
require_once "./util/permission/PermissionCtrl.php";


class DeleteUserByIdCommand implements Command
{
    public function execute(): void
    {
        PermissionCtrl::permissionCheck('admin');

        $user = $_SESSION['user'];
        if ($user->getRole() == 'admin') {
            FactoryService::getInstance()->getUserService()->delete($_POST["user_id_for_deleting"]);
            header('Location: http://localhost/');
            exit();
        }
        Router::redirect();


    }
}