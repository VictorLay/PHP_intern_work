<?php

namespace app\core\utils;

use JetBrains\PhpStorm\NoReturn;

class Redirection
{
    /**
     * If the PHP-interpreter write to browser html (outside of ?<php)response before execution of @param string $path
     * @return void
     * @link redirect method
     * it will give an error.
     */

    #[NoReturn] public static function redirect(string $path = "/"): void
    {
        header("Location: http://localhost" . $path);
        exit();
    }

    #[NoReturn] public static function innerRedirect(string $path):void{
        header("Status: 200 OK");

        $dir =dirname($_SERVER['SCRIPT_NAME']);

        header("Location: $dir/$path");
        exit();
    }

}