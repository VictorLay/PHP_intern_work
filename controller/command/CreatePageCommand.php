<?php
require_once "./controller/Command.php";
require_once "./util/permission/PermissionCtrl.php";
require_once "./resources/conf_const.php";


class CreatePageCommand extends PermissionCtrl implements Command
{
    private array $requiredPostKeys;

    public function __construct()
    {
        parent::__construct();
        $this->setAccessedRoles([ADMIN]);
        $this->requiredPostKeys = ["user_email", "user_country", "user_name"];
    }

    public function execute(): void
    {
        if ($this->checkUserPermission()) {
            if ($this->checkPostKeys($this->requiredPostKeys) ) {
                $user = new User();

                $user->setEmail($_POST["user_email"]);
                $user->setCountry($_POST["user_country"]);
                $user->setName($_POST["user_name"]);
                $user->setRole(USER);
                $user->setAvatarPath("./resources/default_avatar.jpg");

                $userService = FactoryService::getInstance()->getUserService();

                if ($userService->create($user)) {
                    $newUserId = $userService->showUser(new AuthorizationInfo("1234", $user->getEmail()))->getId();
                    Router::redirect(SHOW_USER_PAGE."?user_id=$newUserId");
                } else {
                    HtmlPageWriter::writeCreateUserHtmlForm();
                }
            } else {
                HtmlPageWriter::writeCreateUserHtmlForm();
            }
        } else {
            HtmlPageWriter::write403ErrorPage();
        }


    }

}