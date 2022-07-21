<?php

class SignOutPageController extends PermissionCtrl implements Controller
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
            Redirection::redirect();
        }
    }
}