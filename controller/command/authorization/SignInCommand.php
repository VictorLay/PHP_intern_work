<?php
require_once "./controller/Command.php";
require_once "./bean/info/AuthorizationInfo.php";
require_once "./util/HtmlPageWriter.php";

class SignInCommand implements Command
{
    public function execute(): void
    {

        if (key_exists("mail", $_POST) && key_exists("password", $_POST)) {
            $mail = $_POST['mail'];
            $password = $_POST['password'];
            $authorizationInfo = new AuthorizationInfo($password, $mail);
            $userService = FactoryService::getInstance()->getUserService();
            if ($userService->isUserExist($authorizationInfo)) {
                $user = $userService->showUser($authorizationInfo);
                $_SESSION['user'] = $user;
                Router::redirect();
            } else {
                HtmlPageWriter::writeSignInFormWithAuthorizationWarning();
            }
        } else {
            HtmlPageWriter::write404ErrorPage();
        }
    }
}