<?php
require_once "./controller/Command.php";
require_once "./bean/User.php";
require_once "./service/factory/FactoryService.php";
require_once "./util/permission/PermissionCtrl.php";
require_once "./util/HtmlPageWriter.php";
require_once "./resources/conf_const.php";

class UpdateUserCommand extends PermissionCtrl implements Command
{
    private Logger $logger;
    private array $requiredPostKeys;

    public function __construct()
    {
        $this->logger = Logger::getLogger();
        $this->setAccessedRoles([ADMIN]);
        $this->requiredPostKeys = [
            "user_id", "user_email", "user_country", "user_name", "user_role"
        ];
    }

    public function execute(): void
    {
        if ($this->checkUserPermission() && $this->checkPostKeys()){

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
        }else{
            HtmlPageWriter::write404ErrorPage();
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