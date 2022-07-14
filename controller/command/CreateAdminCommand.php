<?php
require_once "./service/factory/FactoryService.php";
require_once "./controller/Command.php";
require_once "./util/Router.php";
require_once "./util/HtmlPageWriter.php";
require_once "./util/permission/PermissionCtrl.php";

class CreateAdminCommand extends PermissionCtrl implements Command
{
    private array $requiredPostKeys;

    public function __construct()
    {
        $this->requiredPostKeys = [
            "user_email", "user_country", "user_name"
        ];
    }

    public function execute(): void
    {
        if ($this->checkPostKeys($this->requiredPostKeys)) {
            $userService = FactoryService::getInstance()->getUserService();
            $user = new User();

            $user->setEmail($_POST["user_email"]);
            $user->setCountry($_POST["user_country"]);
            $user->setName($_POST["user_name"]);
            $user->setRole('admin');

            $userService->create($user);
            Router::redirect();
        } else {
            HtmlPageWriter::write404ErrorPage();
        }


    }

}