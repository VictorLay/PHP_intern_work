<?php

class DeleteUserByIdPageController extends PermissionCtrl implements Controller
{

    public function __construct()
    {
        $this->setAccessedRoles([ADMIN]);
    }

    public function execute(): void
    {

        $userService = ServiceFactory::getInstance()->getUserService();

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
                    Redirection::redirect();
                }
            }else{
                HtmlPageWriter::write404ErrorPage();
            }
        }


    }
}