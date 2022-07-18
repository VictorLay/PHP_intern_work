<?php
require_once "./controller/Command.php";
require_once "./util/HtmlPageWriter.php";

class HomePageCommand implements Command
{
    public function execute(): void
    {
        $userFromSession = key_exists('user', $_SESSION) ? $_SESSION['user'] : null;
        HtmlPageWriter::writeHomePage($userFromSession);
    }

}