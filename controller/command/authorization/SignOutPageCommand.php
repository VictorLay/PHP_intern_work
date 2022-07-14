<?php
require_once "./resources/conf_const.php";
require_once "./util/Router.php";

class SignOutPageCommand extends PermissionCtrl implements Command
{


    public function __construct()
    {
        $this->setAccessedRoles([USER, ADMIN]);
    }

    public function execute(): void
    {
        if ($this->checkUserPermission()) {
            HtmlPageWriter::writeSignOutWarning();
        }else{
            HtmlPageWriter::write404ErrorPage();
        }
    }
}