<?php

class SignInPageController implements Controller
{

    private Logger $logger;

    public function __construct()
    {
        $this->logger = Logger::getLogger("controller");
    }


    public function execute(): void
    {
        if (isset($_SESSION['user'])) {
            Redirection::redirect();
        } else {
            if (key_exists("mail", $_POST) && key_exists("password", $_POST)) {
                $mail = $_POST['mail'];
                $password = $_POST['password'];
                $authorizationInfo = new AuthorizationInfo($password, $mail);
                $userService = ServiceFactory::getInstance()->getUserService();
                if ($userService->isUserExist($authorizationInfo)) {
                    $user = $userService->showUser($authorizationInfo);
                    $_SESSION['user'] = $user;
                    Redirection::redirect(HOME_PAGE . "/" . $user->getId() . "/profile");
                } else {
                    $_SESSION['login'] = $_POST['mail'];
                    Redirection::redirect(LOGIN_PAGE);
                }
            } else {
                HtmlPageWriter::writeSignInForm(key_exists('login', $_SESSION) ? $_SESSION['login'] : null);
                unset($_SESSION['login']);
            }
        }


    }
}