<?php
require_once "./controller/Command.php";

class SignOutCommand implements Command
{
    public function execute(): void
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
        header('Location: http://localhost/');
        exit();
    }

}