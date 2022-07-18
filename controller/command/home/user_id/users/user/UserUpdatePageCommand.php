<?php
require_once "./controller/Command.php";
require_once "./util/permission/PermissionCtrl.php";
require_once "./resources/conf_const.php";
require_once "./service/factory/FactoryService.php";
require_once "./util/logger/Logger.php";

class UserUpdatePageCommand extends PermissionCtrl implements Command
{
    private Logger $logger;
    private array $requiredPostKeys;

    public function __construct()
    {
        parent::__construct();
        $this->logger = Logger::getLogger();
        $this->setAccessedRoles([ADMIN]);
        $this->requiredPostKeys = ["user_email", "user_country", "user_name", "user_id", "user_role"];
    }

    public function execute(): void
    {
        $userService = FactoryService::getInstance()->getUserService();
        if($this->isUserForUpdateNotAdmin()) {
            if ($this->checkPostKeys($this->requiredPostKeys) && $this->checkUserPermission()) {
                /** @var User $userFromSession */
                $userFromSession = $_SESSION['user'];
                $newUser = $this->setNewUser();

                if ($userService->update($newUser)) {
                    unset($_SESSION['not_valid_user_data']);
                    unset($_SESSION['validator_response']);
                    Router::redirect(SHOW_USER_PAGE . "?user_id=" . $newUser->getId());
                } else {
                    HtmlPageWriter::writeUpdateUserHtmlFormWithWarning($newUser, $userFromSession);
                }

            } else {
                if ($this->checkUserPermission() && key_exists("user_id", $_GET)) {
                    /** @var User $userFromSession */
                    $userFromSession = $_SESSION['user'];
                    $userIdFromQuery = $_GET['user_id'];
                    $this->getUserUpdatePage($userFromSession, $userIdFromQuery);
                } else {
                    HtmlPageWriter::write403ErrorPage();
                }
            }
        }else{
            Router::redirect(UPDATE_USER_PAGE);
        }

    }

    private function isUserForUpdateNotAdmin(): bool
    {
        $userService = FactoryService::getInstance()->getUserService();
        if (key_exists('user_id', $_GET)) {
            $user = $userService->findUser($_GET['user_id']);
            return $user->getRole() != ADMIN;
        }
        if (key_exists('user_id', $_POST)) {
            $user = $userService->findUser($_POST['user_id']);
            return $user->getRole() != ADMIN;
        }
        return true;
    }

    private function getUserUpdatePage(User $userFromSession, int $userIdFromQuery): void
    {
        $userService = FactoryService::getInstance()->getUserService();
        /** @var User $userForUpdating */
        $userForUpdating = $userService->findUser($userIdFromQuery);
        if (is_null($userForUpdating)) {
            HtmlPageWriter::writeGetFormForIncorrectUserId();
        } else {
            if ($userForUpdating->getRole() != ADMIN || $userForUpdating->getId() == $userFromSession->getId()) {
                HtmlPageWriter::writeUpdateUserHtmlForm($userForUpdating, $userFromSession);
            } else {
                echo "Вы не можете редактировать Admin пользователя";
            }
        }
    }

    private function setNewUser(): User
    {
        $userService = FactoryService::getInstance()->getUserService();
        $oldUserForUpdating = $userService->findUser($_POST['user_id']);
        $newUser = new User();
        $newUser->setId($oldUserForUpdating->getId());
        $newUser->setEmail($_POST["user_email"]);
        $newUser->setCountry($_POST["user_country"]);
        $newUser->setName($_POST["user_name"]);
        $newUser->setAvatarPath($oldUserForUpdating->getAvatarPath());
        $newUser->setRole($_POST['user_role']);
        return $newUser;
    }

}