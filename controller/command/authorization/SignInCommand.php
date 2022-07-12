<?php
require_once "./controller/Command.php";
require_once "./bean/info/AuthorizationInfo.php";

class SignInCommand implements Command
{
    public function execute(): void
    {

        $mail = $_POST['mail'];
        $password = $_POST['password'];
        $authorizationInfo = new AuthorizationInfo($password, $mail);
        $userService = FactoryService::getInstance()->getUserService();
        if ($userService->isUserExist($authorizationInfo)) {
            $user = $userService->showUser($authorizationInfo);
            $_SESSION['user'] = $user;
            header('Location: http://localhost/');
            exit();
        }else{
            HtmlPageWriter::writeSignInFormWithAuthorizationWarning();
        };



    }
}