<?php

class HomePageController implements Controller
{
    public function execute(): void
    {
        $userFromSession = key_exists('user', $_SESSION) ? $_SESSION['user'] : null;
        HtmlPageWriter::writeHomePage($userFromSession);
    }

}