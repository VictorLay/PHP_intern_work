<?php

namespace app\users\controllers;


use app\core\services\factory\ServiceFactory;
use app\core\utils\permission\impl\PermissionImpl;
use app\core\utils\Redirection;
use app\users\entities\AuthorizationInfo;
use app\users\entities\User;
use app\users\views\HtmlUserPageWriter;

/** @link Router */
class UserController extends PermissionImpl
{

    public function displayHomePage(array $infFromUri): void
    {
        $userFromSession = key_exists('user', $_SESSION) ? $_SESSION['user'] : null;
        HtmlUserPageWriter::writeHomePage($userFromSession);
    }

    public function displayLoginPage(array $infFromUri): void
    {
        if (isset($_SESSION['user'])) {
            Redirection::redirect();
        }

        $requestMethod = $infFromUri['REQUEST_METHOD'];
        switch ($requestMethod) {
            case "GET":
                $this->displayLoginForm();
                break;
            case "POST":
                $this->authorizeUser();
                break;
        }
    }

    public function displayLogoutPage(array $infFromUri): void
    {
        $this->setAccessedRoles([ADMIN, USER]);
        if ($this->checkUserPermission()) {
            $requestMethod = $infFromUri['REQUEST_METHOD'];
            switch ($requestMethod) {
                case "GET":
                    $this->displayLogoutForm();
                    break;
                case "POST":
                    $this->logoutUser();
                    break;
            }
        } else {
            Redirection::redirect();
        }
    }

    public function displayUpdatePage(array $infFromUri): void
    {
        $userForUpdateId = intval($infFromUri[1]);
        /** @var User $userFromSession */
        $userFromSession = $_SESSION['user'];
        $this->setAccessedRoles([ADMIN, USER]);
        $userService = ServiceFactory::getInstance()->getUserService();
        if ($userService->findUser($userForUpdateId) == null) {
            HtmlUserPageWriter::write404ErrorPage();
            Redirection::redirect(SHOW_ALL_USERS_PAGE);
        }
        if ($this->checkUserPermission()) {
            $requestMethod = $infFromUri['REQUEST_METHOD'];
            switch ($requestMethod) {
                case "GET":
                    $this->displayUpdateUserForm($userFromSession, $userForUpdateId);
                    break;
                case "POST":

                    if ($userFromSession->getId() == $userForUpdateId) {
                        $requiredPostKeys = ["user_email", "user_country", "user_name"];
                        $this->updateUser($requiredPostKeys, $userFromSession, true);
                    } elseif ($userFromSession->getRole() == ADMIN && $userService->findUser($userForUpdateId)->getRole() != ADMIN) {
                        $requiredPostKeys = ["user_email", "user_country", "user_name", "user_role"];
                        $this->updateUser($requiredPostKeys, $userFromSession, false, $userForUpdateId);
                    } else {
                        HtmlUserPageWriter::write403ErrorPage();
                    }
                    break;
            }

        } else {
            HtmlUserPageWriter::write404ErrorPage();
        }

    }

    public function displayDeletePage(array $infFromUri): void
    {
        /** @var User $userFromSession */
        $userFromSession = $_SESSION['user'];
        $deletingUserId = intval($infFromUri[1]);
        $this->setAccessedRoles([ADMIN]);
        $userService = ServiceFactory::getInstance()->getUserService();
        $userForDeleting = $userService->findUser($deletingUserId);
        $isUserForDeletingExist = !(is_null($userForDeleting));

        if (
            $this->checkUserPermission() &&
            $isUserForDeletingExist &&
            $userForDeleting->getRole() != ADMIN &&
            $deletingUserId != $userFromSession->getId()
        ) {

            $requestMethod = $infFromUri['REQUEST_METHOD'];
            switch ($requestMethod) {
                case "GET":
                    HtmlUserPageWriter::writeDeleteUserHtmlForm($deletingUserId);
                    break;
                case "POST":
                    $userService->delete($deletingUserId);
                    HtmlUserPageWriter::writeSuccessDeletingMessage($userForDeleting);
                    break;
            }
        } else {
            HtmlUserPageWriter::write403ErrorPage();
        }
    }

    public function displayCreateUserPage(array $infFromUri): void
    {
        $this->setAccessedRoles([ADMIN]);
        $this->requiredPostKeys = ["user_email", "user_country", "user_name"];

        if ($this->checkUserPermission()) {
            $requestMethod = $infFromUri['REQUEST_METHOD'];
            switch ($requestMethod) {
                case "GET":
                    HtmlUserPageWriter::writeCreateUserHtmlForm();
                    break;
                case "POST":
                    if ($this->checkPostKeys($this->requiredPostKeys)) {
                        $user = new User();

                        $user->setEmail($_POST["user_email"]);
                        $user->setCountry($_POST["user_country"]);
                        $user->setName($_POST["user_name"]);
                        $user->setRole(USER);
                        $user->setAvatarPath("img/avatars/default_avatar.jpg");

                        $userService = ServiceFactory::getInstance()->getUserService();

                        if ($userService->create($user)) {
                            $newUserId = $userService->showUser(new AuthorizationInfo("1234", $user->getEmail()))->getId();
                            Redirection::redirect(SHOW_ALL_USERS_PAGE . "/$newUserId");
                        } else {
                            HtmlUserPageWriter::writeCreateUserHtmlForm();
                            unset($_SESSION["not_valid_user_data"]);
                            unset($_SESSION["validator_response"]);
                        }
                    } else {
                        HtmlUserPageWriter::write422ErrorPage();
                    }
                    break;
            }
        } else {
            HtmlUserPageWriter::write403ErrorPage();
        }
    }

    public function displayUsersPage(array $infFromUri): void
    {
        $this->setAccessedRoles([ADMIN, USER]);

        if ($this->checkUserPermission()) {

            $requestMethod = $infFromUri['REQUEST_METHOD'];
            switch ($requestMethod) {
                case "GET":
                    /** @var User $userFromSession */
                    $userFromSession = $_SESSION['user'];
                    $userService = ServiceFactory::getInstance()->getUserService();
                    $pageQuantity = ceil($userService->countUsers() / NUM_OF_USERS_ON_ONE_PAGE);
                    $page = $this->checkGetPageRequest($pageQuantity);
                    $users = $userService->showSeparately($page);

                    switch ($userFromSession->getRole()) {
                        case ADMIN:
                            $this->displayUsersForAdmin($users, $pageQuantity, $userFromSession);
                            break;
                        case USER:
                            $this->displayUsersForUser($users, $pageQuantity);
                            break;
                    }
                    break;
                case "POST":
                    HtmlUserPageWriter::write405ErrorPage();
                    break;
            }
        } else {
            HtmlUserPageWriter::write403ErrorPage();
        }


    }

    public function displayUserProfilePage(array $infFromUri): void
    {
        define("SIGNED_USER", true);
        define("UNSIGNED_USER", false);

        $userIdForLooking = $infFromUri[1];
        $this->setAccessedRoles([ADMIN, USER]);
        if ($this->checkUserPermission()) {
            /** @var User $userFromSession */
            $userFromSession = $_SESSION['user'];
            $userService = ServiceFactory::getInstance()->getUserService();
            switch ($userIdForLooking == $userFromSession->getId()) {
                case SIGNED_USER:
                    HtmlUserPageWriter::writeSignedUserProfile($userFromSession);
                    break;
                case UNSIGNED_USER:
                    $this->setAccessedRoles([ADMIN]);
                    if ($this->checkUserPermission()) {
                        $userForLooking = $userService->findUser($userIdForLooking);
                        if (is_null($userForLooking)) {
                            Redirection::redirect(SHOW_ALL_USERS_PAGE);
                        }
                        HtmlUserPageWriter::writeUserProfile($userForLooking);
                    } else {
                        HtmlUserPageWriter::write403ErrorPage();
                    }
                    break;
            }
        } else {
            HtmlUserPageWriter::write404ErrorPage();
        }
    }


    private function updateUser(
        array $requiredPostKeys,
        User  $userFromSession,
        bool  $isUpdateYourself,
        int   $userForUpdateId = 0
    ): void
    {
        $userService = ServiceFactory::getInstance()->getUserService();

        if ($isUpdateYourself) {
            $userForUpdating = $userFromSession;
        } else {
            $userForUpdating = $userService->findUser($userForUpdateId);
        }

        if ($this->checkPostKeys($requiredPostKeys)) {
            $newUser = $this->setNewUser($userForUpdating, $isUpdateYourself);
            if ($userService->update($newUser)) {
                unset($_SESSION['not_valid_user_data']);
                unset($_SESSION['validator_response']);
                $newUser = $this->updatePath($newUser);
                $userService->update($newUser);
                if ($isUpdateYourself) {
                    $_SESSION['user'] = $newUser;
                }
                Redirection::redirect(SHOW_ALL_USERS_PAGE . "/" . $newUser->getId());
            } else {
                HtmlUserPageWriter::writeUpdateUserHtmlFormWithWarning($newUser, $userFromSession);
            }

        } else {
            HtmlUserPageWriter::write405ErrorPage();
        }
    }

    private function updatePath(User $updatedUser): User
    {
        $info = new SplFileInfo($updatedUser->getAvatarPath());
        $path = AVATAR_PATH . $updatedUser->getId() . "." . $info->getExtension();
        @copy($updatedUser->getAvatarPath(), $path);
        if ( $updatedUser->getAvatarPath() !== "/img/avatars/default_avatar.jpg") {
            @unlink($updatedUser->getAvatarPath());
        }
        $updatedUser->setAvatarPath($path);
        return $updatedUser;
    }

    private function setNewUser(User $userForUpdating, bool $isUpdateYourself = true): User
    {
        $oldUserForUpdating = $userForUpdating;
        $newUser = new User();
        $newUser->setId($oldUserForUpdating->getId());
        $newUser->setEmail($_POST["user_email"]);
        $newUser->setCountry($_POST["user_country"]);
        $newUser->setName($_POST["user_name"]);

        if ($isUpdateYourself) {
            $newUser->setRole($oldUserForUpdating->getRole());
            $newUser->setAvatarPath($this->setNewPicToTmpFile($oldUserForUpdating->getAvatarPath(), $newUser->getId()));
        } else {
            $newUser->setAvatarPath($oldUserForUpdating->getAvatarPath());
            $newUser->setRole($_POST['user_role']);
        }

        return $newUser;
    }

    /**  если пришёл файл,то копируем его во временное хранилище и возвращаем путь файла
     *   в противном случае возвращаем дефолтный путь (указанный при вызове метода)
     */
    private function setNewPicToTmpFile(string $defaultPath, int $userId): string
    {
        $path = AVATAR_PATH . "$userId-tmp.png";
        if (key_exists('picture', $_FILES) && !empty($_FILES['picture']['name'])) {
            if (copy($_FILES['picture']['tmp_name'], $path)) {
                return $path;
            } else {
                return $defaultPath;
            }
        } else {
            if (file_exists($path)) {
                return $path;
            }
            return $defaultPath;
            //добавить проверку на наличие временного файла и вернуть его путь при его существовании

        }
    }

    private function displayUpdateUserForm(User $userFromSession, int $userForUpdateId): void
    {
        if ($userFromSession->getId() == $userForUpdateId) {
            HtmlUserPageWriter::writeSignedUserUpdateForm($userFromSession);
        } else {
            $userService = ServiceFactory::getInstance()->getUserService();
            $userForUpdating = $userService->findUser($userForUpdateId);
            if ($userForUpdating->getRole() != ADMIN) {
                HtmlUserPageWriter::writeUpdateUserHtmlForm($userForUpdating, $userFromSession);
            } else {
                HtmlUserPageWriter::write403ErrorPage();
            }
        }
    }

    private function displayUsersForAdmin(array $users, int $pageQuantity, User $userFromSession): void
    {
        HtmlUserPageWriter::writeAllUsersForAdmin($users, $pageQuantity, $userFromSession);
    }

    private function displayUsersForUser(array $users, int $pageQuantity): void
    {
        HtmlUserPageWriter::writeAllUsersForUser($users, $pageQuantity);
    }

    private function checkGetPageRequest(int $pageQuantity): int
    {
        $page = min(key_exists('page', $_GET) ? $_GET['page'] : 1, $pageQuantity);
        $_GET['page'] = $page;
        if ($page < 1) {
            $page = 1;
        }
        return $page;
    }

    private function displayLogoutForm(): void
    {
        $user = $_SESSION['user'];
        HtmlUserPageWriter::writeSignOutWarning($user);
    }

    private function logoutUser(): void
    {
        if ($this->checkPostKeys(['sign_out'])) {
            unset($_SESSION['user']);
            Redirection::redirect();
        }
        HtmlUserPageWriter::write422ErrorPage();
    }

    private function displayLoginForm(): void
    {
        HtmlUserPageWriter::writeLoginForm();
    }

    private function authorizeUser(): void
    {
        if (key_exists("mail", $_POST) && key_exists("password", $_POST)) {
            $mail = $_POST['mail'];
            $password = $_POST['password'];

            $authorizationInfo = new AuthorizationInfo($password, $mail);
            $userService = ServiceFactory::getInstance()->getUserService();

            if ($userService->isUserExist($authorizationInfo)) {
                $user = $userService->showUser($authorizationInfo);
                $_SESSION['user'] = $user;
                Redirection::redirect(HOME_PAGE);
            } else {
                HtmlUserPageWriter::writeLoginFormWithWarning($mail);
            }
        } else {
            HtmlUserPageWriter::write403ErrorPage();
        }

    }
}
