<?php
require_once "./controller/CommandProvider.php";
require_once "./util/logger/Logger.php";

class Controller
{

    private function __construct()
    {
    }

    public static function run(): void
    {
        self::init();
        self::service();
        self::destroy();

    }

    private static function init(): void
    {
        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        $logger = Logger::getLogger();
        $logger->setLogLevel(DEBUG_LEVEL);

        if (session_status() == PHP_SESSION_NONE){
            session_start();
        }
    }

    private static function service(): void
    {
        echo "<h2><a href='/'>HOME</a> </h2>";
        $commandName = array_key_exists('command', $_POST) ? $_POST['command'] : 'default';
        $command = CommandProvider::getCommand($commandName);
        $command->execute();
    }

    private static function destroy(): void
    {
        unset($_SESSION['not_valid_user_data']);
    }
}