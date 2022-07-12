<?php
require_once "./controller/Command.php";
require_once "./util/logger/Logger.php";


class DefaultCommand implements Command
{
    private Logger $logger;

    public function __construct()
    {
        $this->logger = Logger::getLogger();
    }

    public function execute(): void
    {
        if (isset($_SESSION['user'])) {
            HtmlPageWriter::writeUserInfo($_SESSION['user']);
            HtmlPageWriter::writeSignOutUserForm();

            $userService = FactoryService::getInstance()->getUserService();
            $pageQuantity = ceil($userService->countUsers() / 5);

            $page = min(key_exists('page', $_GET) ? $_GET['page'] : 1, $pageQuantity);
            if ($page < 1)
                $page = 1;

            $arrayOfUsers = $userService->showSeparately($page);

            /** @var User $user */
            $user = $_SESSION['user'];
            if ($user->getRole() == "admin") {
                $this->logger->log("The admin visit Home page",INFO_LEVEL);
                HtmlPageWriter::writeCreateUserButton();
                HtmlPageWriter::writeAllUsersForAdmin($arrayOfUsers, $pageQuantity);
            } else {
                $this->logger->log("The user visit Home page",INFO_LEVEL);
                HtmlPageWriter::writeAllUsersForUser($arrayOfUsers, $pageQuantity);
            }
        } else {
            $this->logger->log("The unknown user visit Home page",INFO_LEVEL);
            HtmlPageWriter::writeSignInButton();
        }
    }
}