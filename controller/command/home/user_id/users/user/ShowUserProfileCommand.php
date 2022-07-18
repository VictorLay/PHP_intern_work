<?php
require_once "./util/Router.php";
require_once "./util/permission/PermissionCtrl.php";
require_once "./bean/User.php";
require_once "./controller/Command.php";
require_once "./util/HtmlPageWriter.php";

class ShowUserProfileCommand extends PermissionCtrl implements Command
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
            $userService = FactoryService::getInstance()->getUserService();
            $userForLooking = $userService->findUser($userIdForLooking);
            if (is_null($userForLooking)) {
                HtmlPageWriter::writeGetFormForIncorrectUserId();
            } else {
                if ($userFromSession->getId() == $userForLooking->getId()) {
                    Router::redirect(PROFILE_PAGE);
                } else {
                    HtmlPageWriter::writeUserProfile($userForLooking);
                }
            }
        } else {
            HtmlPageWriter::write403ErrorPage();
        }
    }

}