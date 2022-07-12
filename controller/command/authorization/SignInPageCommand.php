<?php
require_once "./controller/Command.php";

class SignInPageCommand implements Command
{
    public function execute(): void
    {
        if (isset($_SESSION['user'])) {
            header('Location: http://localhost/');
            exit();
        } else {
            HtmlPageWriter::writeSignInForm();
        }
    }
}