<?php
require_once "./controller/Command.php";
require_once "./util/permission/PermissionCtrl.php";

class DeleteUserByIdPageCommand implements Command
{
    public function execute(): void
    {
        PermissionCtrl::permissionCheck('admin');
        $deletingUserId = $_POST['user_id'];
        HtmlPageWriter::writeDeleteUserHtmlForm($deletingUserId);
        header("location :http://localhost/");
        exit();
    }

}