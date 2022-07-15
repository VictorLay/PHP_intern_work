<?php
require_once "./controller/Command.php";
require_once "./util/permission/PermissionCtrl.php";
require_once "./resources/conf_const.php";
require_once "./service/factory/FactoryService.php";
require_once "./util/logger/Logger.php";


class UpdateUserPageCommand extends PermissionCtrl implements Command
{
    private array $requiredPostKeys;
    private Logger $logger;

    public function __construct()
    {
        parent::__construct();
        $this->logger = Logger::getLogger();
        $this->setAccessedRoles([ADMIN]);
        $this->requiredPostKeys = [
            "user_id"
        ];
    }

    public function execute(): void
    {
        $userService = FactoryService::getInstance()->getUserService();

        //todo  отрефакторить костыль в этом месте
        if (!key_exists("user_name", $_POST)) {
            if ($this->checkPostKeys($this->requiredPostKeys) && $this->checkUserPermission(isset($_SESSION['user']))) {
//                if (key_exists("not_valid_user_data", $_SESSION)) {
//                    echo $_SESSION['validator_response'];
//                }
                $userFromSession = $_SESSION['user'];
                $userForUpdating = $userService->findUser($_POST['user_id']);
                HtmlPageWriter::writeUpdateUserHtmlForm($userForUpdating, $userFromSession);
            } else {
                HtmlPageWriter::write404ErrorPage();
            }
        } else {
            $this->requiredPostKeys = [
                "user_id", "user_email", "user_country", "user_name"
            ];
            if ($this->checkPostKeys($this->requiredPostKeys) && $this->checkUserPermission(isset($_SESSION['user']))) {
//            /** @var User $oldUser */
//            $oldUser = $_SESSION['user'];
                /** @var User $userFromSession */
                $userFromSession = $_SESSION['user'];
                $oldUserForUpdating = $userService->findUser($_POST['user_id']);
                $oldAvatarPath = $oldUserForUpdating->getAvatarPath();
                $newUser = new User();

                $newUser->setId($_POST["user_id"]);
                $newUser->setEmail($_POST["user_email"]);
                $newUser->setCountry($_POST["user_country"]);
                $newUser->setName($_POST["user_name"]);
                $newUser->setRole(key_exists('user_role', $_POST) ? $_POST['user_role'] : $oldUserForUpdating->getRole());
                $newUser->setAvatarPath($this->extractPicturePath($oldAvatarPath, $newUser->getId()));

                if ($userService->update($newUser)) {

                    unset($_SESSION['not_valid_user_data']);
                    unset($_SESSION['validator_response']);
                    $_SESSION['user'] = $userService->findUser($userFromSession->getId());
                    Router::redirect();
                } else {
                    HtmlPageWriter::writeUpdateUserHtmlFormWithWarning($newUser, $userFromSession);
                }
            }

        }

    }

    private function extractPicturePath(string $defaultPath, int $userId): string
    {
        if (key_exists('picture', $_FILES) && !empty($_FILES['picture']['name'])) {
            $info = new SplFileInfo($_FILES['picture']['name']);
            $this->logger->log($info->getExtension() ,ERROR_LEVEL);
            $path = './resources/' . $userId.".".$info->getExtension();
            if (@copy($_FILES['picture']['tmp_name'], $path)) {
                unlink($defaultPath);
                return $path;
            } else {
                return $defaultPath;
            }
        } else {
            return $defaultPath;
        }
    }

}