<?php
require_once "./controller/Command.php";
require_once "./util/permission/PermissionCtrl.php";
require_once "bean/User.php";

class ShowAllUsersPageCommand extends PermissionCtrl implements Command
{

    public function __construct()
    {
        $this->setAccessedRoles([USER, ADMIN]);
    }

    public function execute(): void
    {

        if ($this->checkUserPermission()) {
            /** @var User $userFromSession */
            $userFromSession = $_SESSION['user'];

            HtmlPageWriter::writeUserInfo($userFromSession);
            HtmlPageWriter::writeSignOutUserForm();
            HtmlPageWriter::writeProfileButton();

            $userService = FactoryService::getInstance()->getUserService();
            $pageQuantity = ceil($userService->countUsers() / NUM_OF_USERS_ON_ONE_PAGE);
            $page = $this->checkGetPageRequest($pageQuantity);

            $arrayOfUsers = $userService->showSeparately($page);
            if ($userFromSession->getRole() == "admin") {
                HtmlPageWriter::writeCreateUserButton();
                HtmlPageWriter::writeAllUsersForAdmin($arrayOfUsers, $pageQuantity, $userFromSession);
            } else {
                HtmlPageWriter::writeAllUsersForUser($arrayOfUsers, $pageQuantity);
            }
        } else {
            HtmlPageWriter::writeSignInButton();
        }
    }

    private function checkGetPageRequest(int $pageQuantity):int{
        $page = min(key_exists('page', $_GET) ? $_GET['page'] : 1, $pageQuantity);
        $_GET['page'] = $page;
        if ($page < 1) {
            $page = 1;
        }
        return $page;
    }
}