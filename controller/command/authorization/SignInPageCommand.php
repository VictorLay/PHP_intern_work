<?php
require_once "./controller/Command.php";
require_once "./util/Router.php";

class SignInPageCommand implements Command
{
    public function execute(): void
    {
        if (isset($_SESSION['user'])) {
            Router::redirect();
        } else {
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
                    $_SESSION['login'] = $_POST['mail'];
                    Router::redirect(LOGIN_PAGE);
                }
            } else {
                HtmlPageWriter::writeSignInForm(key_exists('login', $_SESSION) ? $_SESSION['login'] : null);
                unset($_SESSION['login']);
            }
        }


    }
}