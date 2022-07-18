<?php
require_once "./controller/Command.php";
require_once "./util/permission/PermissionCtrl.php";
require_once "./resources/conf_const.php";
require_once "./service/factory/FactoryService.php";

class DeleteUserByIdPageCommand extends PermissionCtrl implements Command
{

    public function __construct()
    {
        $this->setAccessedRoles([ADMIN]);
    }

    public function execute(): void
    {

        $userService = FactoryService::getInstance()->getUserService();

        if (key_exists('user_id', $_GET) && $this->checkUserPermission()) {
            $deletingUserId = intval($_GET['user_id']);
            $userForDeleting = $userService->findUser($deletingUserId);

            if ($userForDeleting->getRole() != ADMIN) {
                HtmlPageWriter::writeDeleteUserHtmlForm($deletingUserId);
            }else{
                HtmlPageWriter::write403ErrorPage();
            }
        }else{
            if ( $this->checkPostKeys(["user_id"]) && $this->checkUserPermission() ){
                $deletingUserId = intval($_POST['user_id']);
                $userForDeleting = $userService->findUser($deletingUserId);
                if ($userForDeleting->getRole() != ADMIN) {
                    $userService->delete($deletingUserId);
                    Router::redirect();
                }
            }else{
                HtmlPageWriter::write404ErrorPage();
            }
        }


    }
}