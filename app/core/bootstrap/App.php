<?php

namespace app\core\bootstrap;

use app\core\utils\logger\Logger;
use app\core\routers\Router;

class App
{

    public function run(): void
    {
        $this->init();
        $this->service();
        $this->destroy();

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
        $uri = $_SERVER['REQUEST_URI'];
        if (preg_match("/\?/", $uri)) {
            $uri = stristr($uri, "?", true);
        }
        $router = new Router();
        $router->doSomething($uri);

    }


    private function destroy(): void
    {
    }
}