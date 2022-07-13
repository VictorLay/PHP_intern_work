<?php
require_once "./controller/Command.php";
require_once "./bean/User.php";
require_once "./service/factory/FactoryService.php";
require_once "./util/Router.php";
require_once "./util/permission/PermissionCtrl.php";
require_once "./resources/conf_const.php";


class DeleteUserByIdCommand extends PermissionCtrl implements Command
{

    public function __construct()
    {
        $this->setAccessedRoles([ADMIN]);
    }

    public function execute(): void
    {
        if ($this->checkUserPermission()){
            $user = $_SESSION['user'];
            if ($user->getRole() == 'admin') {
                FactoryService::getInstance()->getUserService()->delete($_POST["user_id_for_deleting"]);
                header('Location: http://localhost/');
                exit();
            }
        }else{
            Router::redirect();
        }
    }
}