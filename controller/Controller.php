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

        $loggerController = Logger::getLogger('controller');
        $loggerController->setLogLevel(DEBUG_LEVEL);

        $loggerService = Logger::getLogger('service');
        $loggerService->setLogLevel(NANE_INFO);

        $loggerRoot = Logger::getLogger();
        $loggerRoot->setLogLevel(NANE_INFO);



        if (session_status() == PHP_SESSION_NONE){
            session_start();
        }
    }

    private static function service(): void
    {
        $logger = Logger::getLogger("controller");
        $uri =$_SERVER['REQUEST_URI'];
        $logger->log($uri, DEBUG_LEVEL);
        if (preg_match("/\?/", $uri)) {
            $uri = stristr($uri, "?", true);
        }
        $command = CommandProvider::getCommand($uri);
//        var_dump($command);
        $command->execute();
    }

//$uri = $_SERVER['REQUEST_URI'];
//$parseUri = explode('/', $uri);
//if(count($parseUri) == 2 and $parseUri[1] == 'users') {
//echo 'Отображаем список юзеров';
//} elseif (count($parseUri)==3) {
//  echo "Отображаем страницу юзера {$parseUri[2]}";
//}
//exit();

    private static function destroy(): void
    {
//        unset($_SESSION['not_valid_user_data']);
//        unset($_SESSION['validator_response']);
    }
}