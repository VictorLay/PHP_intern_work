<?php


class CreatePageController extends PermissionCtrl implements Controller
{
    private array $requiredPostKeys;

    public function __construct()
    {
        parent::__construct();
        $this->setAccessedRoles([ADMIN]);
        $this->requiredPostKeys = ["user_email", "user_country", "user_name"];
    }

    public function execute(): void
    {
        if ($this->checkUserPermission()) {
            if ($this->checkPostKeys($this->requiredPostKeys) ) {
                $user = new User();

                $user->setEmail($_POST["user_email"]);
                $user->setCountry($_POST["user_country"]);
                $user->setName($_POST["user_name"]);
                $user->setRole(USER);
                $user->setAvatarPath("img/avatars/default_avatar.jpg");

                $userService = ServiceFactory::getInstance()->getUserService();

                if ($userService->create($user)) {
                    $newUserId = $userService->showUser(new AuthorizationInfo("1234", $user->getEmail()))->getId();
                    Redirection::redirect(SHOW_USER_PAGE."?user_id=$newUserId");
                } else {
                    HtmlPageWriter::writeCreateUserHtmlForm();
                }
            } else {
                HtmlPageWriter::writeCreateUserHtmlForm();
            }
        } else {
            HtmlPageWriter::write403ErrorPage();
        }


    }

}