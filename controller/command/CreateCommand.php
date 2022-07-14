<?php
require_once "./controller/Command.php";
require_once "./bean/User.php";
require_once "./service/factory/FactoryService.php";
require_once "./util/permission/PermissionCtrl.php";
require_once "./util/Router.php";
require_once "./util/HtmlPageWriter.php";
require_once "./resources/conf_const.php";

class CreateCommand extends PermissionCtrl implements Command
{

    public function __construct()
    {
        $this->setAccessedRoles([ADMIN]);
    }

    public function execute(): void
    {
        if ($this->checkUserPermission() && $this->checkPostKeys(["user_email", "user_country", "user_name"])) {
            $user = new User();

            $user->setEmail($_POST["user_email"]);
            $user->setCountry($_POST["user_country"]);
            $user->setName($_POST["user_name"]);
            $user->setRole('user');
            $user->setAvatarPath("./resources/default_avatar.jpg");

            $userService = FactoryService::getInstance()->getUserService();

            if ($userService->create($user)) {
                Router::redirect();
            } else {
                HtmlPageWriter::writeCreateUserHtmlForm();
            }
        } else {
            HtmlPageWriter::write404ErrorPage();
        }
    }
}