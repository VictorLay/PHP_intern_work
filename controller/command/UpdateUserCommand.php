<?php
//require_once "./controller/Command.php";
//require_once "./bean/User.php";
//require_once "./service/factory/FactoryService.php";
//require_once "./util/permission/PermissionCtrl.php";
//require_once "./util/HtmlPageWriter.php";
//require_once "./resources/conf_const.php";
//
//class UpdateUserCommand extends PermissionCtrl implements Command
//{
//    public function execute(): void
//    {
//        // TODO: Implement execute() method.
//    }
//
//    /*
//    private Logger $logger;
//    private array $requiredPostKeys;
//
//    public function __construct()
//    {
//        $this->logger = Logger::getLogger();
//        $this->setAccessedRoles([ADMIN]);
//        $this->requiredPostKeys = [
//            "user_id", "user_email", "user_country", "user_name"
//        ];
//    }
//
//    public function execute(): void
//    {
//        $userService = FactoryService::getInstance()->getUserService();
//        if ($this->checkPostKeys($this->requiredPostKeys) && $this->checkUserPermission(isset($_SESSION['user']))) {
////            /** @var User $oldUser
////            $oldUser = $_SESSION['user'];
//
//            $oldUserForUpdating = $userService->findUser($_POST['user_id']);
//            $oldAvatarPath = $oldUserForUpdating->getAvatarPath();
//            $newUser = new User();
//
//            $newUser->setId($_POST["user_id"]);
//            $newUser->setEmail($_POST["user_email"]);
//            $newUser->setCountry($_POST["user_country"]);
//            $newUser->setName($_POST["user_name"]);
//            $newUser->setRole(key_exists('user_role', $_POST) ? $_POST['user_role'] : $oldUserForUpdating->getRole());
//            $newUser->setAvatarPath($this->extractPicturePath($oldAvatarPath));
//
//
//            if ($userService->update($newUser)) {
//                $_SESSION['user'] = $newUser;
//                Router::redirect();
//            } else {
//                //back
//            }
//        } else {
//            HtmlPageWriter::write404ErrorPage();
//        }
//    }
//
//    private function extractPicturePath(string $defaultPath): string
//    {
//        $path = './resources/' . $_FILES['picture']['name'];
//        $this->logger->log("default $defaultPath path $path", FATAL_LEVEL);
//        if (empty($path) && !@copy($_FILES['picture']['tmp_name'], $path) || preg_match("/^.\/resources\/$/", $path)) {
//            $this->logger->log("The avatar wasn't uploaded. User will have default avatar.", WARN_LEVEL);
//            return $defaultPath;
//        } else {
//            return $path;
//        }
//    }*/
//}