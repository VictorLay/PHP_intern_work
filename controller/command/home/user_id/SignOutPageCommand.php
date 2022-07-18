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
        if(!key_exists("sign_out", $_POST)) {
            if ($this->checkUserPermission()) {
                $user = $_SESSION['user'];
                HtmlPageWriter::writeSignOutWarning($user);
            } else {
                HtmlPageWriter::write404ErrorPage();
            }
        }else{
            if($this->checkUserPermission()){
                if (isset($_SESSION['user'])) {
                    unset($_SESSION['user']);
                }
            }
            Router::redirect();
        }
    }
}