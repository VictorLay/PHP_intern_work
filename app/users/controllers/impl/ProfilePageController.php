<?php

class ProfilePageController extends PermissionCtrl implements Controller
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

            $userService = ServiceFactory::getInstance()->getUserService();
            $user = $userService->findUser($userFromSession->getId());
            $_SESSION['user'] = $user;
            HtmlPageWriter::writeSignedUserProfile($user, $userFromSession);

        } else {
            HtmlPageWriter::write404ErrorPage();
        }

    }

}