<?php

class App
{

    public function run(): void
    {
        self::init();
        self::service();
        self::destroy();

    }

    private function init(): void
    {
        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        $loggerController = Logger::getLogger('controller');
        $loggerController->setLogLevel(DEBUG_LEVEL);

        $loggerService = Logger::getLogger('service');
        $loggerService->setLogLevel(NANE_INFO);

        $loggerModel = Logger::getLogger('model');
        $loggerModel->setLogLevel(NANE_INFO);

        $loggerRoot = Logger::getLogger();
        $loggerRoot->setLogLevel(NANE_INFO);


        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function service(): void
    {
        $logger = Logger::getLogger("controller");
        $uri = $_SERVER['REQUEST_URI'];
        if (preg_match("/\?/", $uri)) {
            $uri = stristr($uri, "?", true);
        }
        $logger->log($uri, DEBUG_LEVEL);
        $controller = RouterImpl::getController($uri);
        $logger->log($controller::class, DEBUG_LEVEL);
        $controller->execute();
    }



    private static function destroy(): void
    {
//        unset($_SESSION['user']);
    }
}