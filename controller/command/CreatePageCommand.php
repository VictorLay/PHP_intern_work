<?php
require_once "./controller/Command.php";
require_once "./util/permission/PermissionCtrl.php";


class CreatePageCommand implements Command
{
    public function execute(): void
    {
        PermissionCtrl::permissionCheck('admin');
        HtmlPageWriter::writeCreateUserHtmlForm();
    }

}