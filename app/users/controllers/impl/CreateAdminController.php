<?php

class CreateAdminController extends PermissionCtrl implements Controller
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
            $userService = ServiceFactory::getInstance()->getUserService();
            $user = new User();

            $user->setEmail($_POST["user_email"]);
            $user->setCountry($_POST["user_country"]);
            $user->setName($_POST["user_name"]);
            $user->setRole('admin');

            $userService->create($user);
            Redirection::redirect();
        } else {
            HtmlPageWriter::write404ErrorPage();
        }


    }

}