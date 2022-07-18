<?php

require_once "./util/permission/PermissionCtrl.php";
require_once "./controller/Command.php";
require_once "./resources/conf_const.php";
require_once "./util/HtmlPageWriter.php";
require_once "./service/factory/FactoryService.php";
require_once "./util/HtmlPageWriter.php";

class ProfilePageCommand extends PermissionCtrl implements Command
{
    private array $requiredPostKeys;

    public function __construct()
    {
//        $this->requiredPostKeys
        $this->setAccessedRoles([ADMIN, USER]);
    }

    public function execute(): void
    {
        if ($this->checkUserPermission()) {
            /** @var User $userFromSession */
            $userFromSession = $_SESSION['user'];

            $userService = FactoryService::getInstance()->getUserService();
            $user = $userService->findUser($userFromSession->getId());
            $_SESSION['user'] = $user;
            HtmlPageWriter::writeSignedUserProfile($user, $userFromSession);

        } else {
            HtmlPageWriter::write404ErrorPage();
        }

    }

}