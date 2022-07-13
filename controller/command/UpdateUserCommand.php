<?php
require_once "./controller/Command.php";
require_once "./bean/User.php";
require_once "./service/factory/FactoryService.php";
require_once "./util/permission/PermissionCtrl.php";
require_once "./util/HtmlPageWriter.php";

class UpdateUserCommand implements Command
{
    private Logger $logger;

    public function __construct()
    {
        $this->logger = Logger::getLogger();
    }

    public function execute(): void
    {
        PermissionCtrl::permissionCheck("admin");


        $newUser = new User();

        $newUser->setId($_POST["user_id"]);
        $newUser->setEmail($_POST["user_email"]);
        $newUser->setCountry($_POST["user_country"]);
        $newUser->setName($_POST["user_name"]);
        $newUser->setRole($_POST["user_role"]);
        $newUser->setAvatarPath($this->extractPicturePath($_POST["user_path"]));


        $userService = FactoryService::getInstance()->getUserService();
        if ($userService->update($newUser)) {
            Router::redirect();
        } else {
            HtmlPageWriter::writeUpdateUserHtmlForm($newUser);
        }
    }

    private function extractPicturePath(string $defaultPath): string
    {
        $path = './resources/' . $_FILES['picture']['name'];
        $this->logger->log("default $defaultPath path $path",FATAL_LEVEL);
        if (empty($path) && !@copy($_FILES['picture']['tmp_name'], $path) || preg_match("/^.\/resources\/$/", $path)) {
            $this->logger->log("The avatar wasn't uploaded. User will have default avatar.", WARN_LEVEL);
            return $defaultPath;
        }else{
            return $path;
        }
    }
}