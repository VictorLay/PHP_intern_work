<?php
require_once "./service/factory/FactoryService.php";
require_once "./controller/Command.php";
require_once "./util/Router.php";

class CreateAdminCommand implements Command
{
    public function execute(): void
{
    $userService = FactoryService::getInstance()->getUserService();
    $user = new User();

    $user->setEmail($_POST["user_email"]);
    $user->setCountry($_POST["user_country"]);
    $user->setName($_POST["user_name"]);
    $user->setRole('admin');

    $userService->create($user);

    Router::redirect();
}

}