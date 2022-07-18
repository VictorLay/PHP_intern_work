<?php

require_once "./util/HtmlPageWriter.php";
require_once "./bean/User.php";
require_once "./controller/Command.php";
require_once "./util/permission/PermissionCtrl.php";
require_once "./resources/conf_const.php";
require_once "./service/factory/FactoryService.php";
require_once "./util/logger/Logger.php";

class UpdateSignedUserPageCommand extends PermissionCtrl implements Command
{

    private Logger $logger;
    private array $requiredPostKeys;

    public function __construct()
    {
        parent::__construct();
        $this->logger = Logger::getLogger();
        $this->setAccessedRoles([ADMIN, USER]);
        $this->requiredPostKeys = ["user_email", "user_country", "user_name"];
    }

    public function execute(): void
    {

        $userService = FactoryService::getInstance()->getUserService();

        if ($this->checkUserPermission()) {

            if ($this->checkPostKeys($this->requiredPostKeys)) {
                /** @var User $userFromSession */
                $userFromSession = $_SESSION['user'];
                $newUser = $this->setNewUser();
//todo Добавить проверку валидации без применения изменений
                if ($userService->update($newUser)) {
                    unset($_SESSION['not_valid_user_data']);
                    unset($_SESSION['validator_response']);
                    $newUser = $this->updatePath($newUser);
                    $userService->update($newUser);
                    $_SESSION['user'] = $newUser;
                    Router::redirect(PROFILE_PAGE);
                } else {
                    HtmlPageWriter::writeUpdateUserHtmlFormWithWarning($newUser, $userFromSession);
                }

            } else {
                /** @var User $userFromSession */
                $userFromSession = $_SESSION['user'];
                HtmlPageWriter::writeSignedUserUpdateForm($userFromSession);
            }
        } else {
            HtmlPageWriter::write403ErrorPage();
        }


    }


    private function setNewUser(): User
    {
        /** @var User $userFromSession */
        $userFromSession = $_SESSION['user'];
        $oldUserForUpdating = $userFromSession;
        $newUser = new User();
        $newUser->setId($oldUserForUpdating->getId());
        $newUser->setEmail($_POST["user_email"]);
        $newUser->setCountry($_POST["user_country"]);
        $newUser->setName($_POST["user_name"]);
        $newUser->setRole($oldUserForUpdating->getRole());
//        $newUser->setAvatarPath($this->extractPicturePath($oldUserForUpdating->getAvatarPath(), $newUser->getId()));
        $newUser->setAvatarPath($this->getPicPathAndSetNewPicToTmpFile($oldUserForUpdating->getAvatarPath(), $newUser->getId()));

        return $newUser;
    }
    //todo выполнять удаление файла только при прохождении валидации
// создать копию файла под хэшированным урлом
// примвоить путь новому пользователю
// 1) валидация пройденна успешно
//
// 2)валидация не пройдена
//

    /**  если пришёл файл,то копируем его во временное хранилище и возвращаем путь файла
     *   в противном случае возвращаем дефолтный путь (указанный при вызове метода)
     */
    private function getPicPathAndSetNewPicToTmpFile(string $defaultPath, int $userId): string
    {
        $path = './resources/img-storage/tmp/' . $userId . "_tmp.png";
        if (key_exists('picture', $_FILES) && !empty($_FILES['picture']['name'])) {
            if (copy($_FILES['picture']['tmp_name'], $path)) {
                $this->logger->log($path,FATAL_LEVEL);
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


    private function extractPicturePath(string $defaultPath, int $userId): string
    {
        if (key_exists('picture', $_FILES) && !empty($_FILES['picture']['name'])) {
            $info = new SplFileInfo($_FILES['picture']['name']);
            $path = './resources/' . $userId . "." . $info->getExtension();
            if (@copy($_FILES['picture']['tmp_name'], $path)) {
                if ($defaultPath != "./resources/default_avatar.jpg") {
                    if (file_exists($defaultPath)) {
                        unlink($defaultPath);
                    }
                }
                return $path;
            } else {
                return $defaultPath;
            }
        } else {
            return $defaultPath;
        }
    }

    private function updatePath(User $updatedUser): User
    {
//        $pathTmp = './resources/img-storage/tmp/' . $updatedUser->getId() . "_tmp.png";
//        $path = $updatedUser->getAvatarPath();
        $info = new SplFileInfo($updatedUser->getAvatarPath());
        $path = './resources/img-storage/' . $updatedUser->getId() . "." . $info->getExtension();
        @copy($updatedUser->getAvatarPath(), $path);
        @unlink($updatedUser->getAvatarPath());

        $updatedUser->setAvatarPath($path);
        return $updatedUser;


    }

}