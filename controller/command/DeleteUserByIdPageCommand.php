<?php
require_once "./controller/Command.php";
require_once "./util/permission/PermissionCtrl.php";
require_once "./resources/conf_const.php";

class DeleteUserByIdPageCommand extends PermissionCtrl implements Command
{

    public function __construct()
    {
        $this->setAccessedRoles([ADMIN]);
    }

    public function execute(): void
    {
        if ($this->checkUserPermission() && $this->checkPostKeys(["user_id"])){
            $deletingUserId = $_POST['user_id'];
            HtmlPageWriter::writeDeleteUserHtmlForm($deletingUserId);
        }else{
            HtmlPageWriter::write404ErrorPage();
        }
    }
}