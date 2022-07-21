<?php

class ShowUserProfileController extends PermissionCtrl implements Controller
{
    public function __construct()
    {
        $this->setAccessedRoles([ADMIN]);
    }

    public function execute(): void
    {
        if ($this->checkUserPermission() && key_exists("user_id", $_GET)) {
            /** @var User $userFromSession */
            $userFromSession = $_SESSION['user'];
            $userIdForLooking = intval($_GET['user_id']);
            $userService = ServiceFactory::getInstance()->getUserService();
            $userForLooking = $userService->findUser($userIdForLooking);
            if (is_null($userForLooking)) {
                HtmlPageWriter::writeGetFormForIncorrectUserId();
            } else {
                if ($userFromSession->getId() == $userForLooking->getId()) {
                    Redirection::redirect(PROFILE_PAGE);
                } else {
                    HtmlPageWriter::writeUserProfile($userForLooking);
                }
            }
        } else {
            HtmlPageWriter::write403ErrorPage();
        }
    }

}