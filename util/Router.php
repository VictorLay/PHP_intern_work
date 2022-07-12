<?php
require_once "./util/logger/Logger.php";
use JetBrains\PhpStorm\NoReturn;

class Router
{
    /**
     * If the PHP-interpreter write to browser html (outside of ?<php)response before execution of @param string $path
     * @return void
     * @link redirect method
     * it will give an error.
     */
    //todo how to fix it?
    #[NoReturn] public static function redirect(string $path = ""): void
    {
//        if (key_exists("command", $_POST)) {
//            $_SESSION['back_page'] = $_POST['command'];
//        }
        header("Location: http://localhost/" . $path);
        exit();
    }
// public static function red(string $path):RedirectResponse{
//     return new RedirectResponse($url);
// }
}