<?php
require_once "./controller/Command.php";
require_once "./util/permission/PermissionCtrl.php";


class UpdateUserPageCommand implements Command
{
    public function execute(): void
    {
        if(key_exists("not_valid_user_data", $_SESSION)){
            echo $_SESSION['validator_response'];
        }
        PermissionCtrl::permissionCheck('admin');

        $user = new User();

        $user->setName($_POST['user_name']);
        $user->setRole($_POST['user_role']);
        $user->setCountry($_POST['user_country']);
        $user->setEmail($_POST['user_email']);
        $user->setId($_POST['user_id']);
        $user->setAvatarPath($_POST['user_path']);
        HtmlPageWriter::writeUpdateUserHtmlForm($user);
    }

}