<?php
require_once "./controller/Command.php";
require_once "./util/permission/PermissionCtrl.php";
require_once "./resources/conf_const.php";


class CreatePageCommand extends PermissionCtrl implements Command
{

    public function __construct()
    {
        $this->setAccessedRoles([ADMIN]);
    }

    public function execute(): void
    {
        if ($this->checkUserPermission()){
            HtmlPageWriter::writeCreateUserHtmlForm();
        }else{
            HtmlPageWriter::write404ErrorPage();
        }
    }

}