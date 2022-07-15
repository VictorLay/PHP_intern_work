<?php
require_once "./resources/CustomConstants.php";
require_once "./util/logger/Logger.php";
require_once "./util/Router.php";
require_once "./controller/Controller.php";

class Handler
{
    private static Logger $logger;

    public static function init(): void
    {
        self::$logger = Logger::getLogger("HANDLER_LOGGER");
        self::$logger->setLogLevel(INFO_LEVEL);
    }

    public static function run(string|int $handlerSetUp = 1): void
    {
        self::init();
        switch ($handlerSetUp) {
            case 1:
                self::executeWithHandler();
                self::$logger->log("The set up was executed with handler.");
                break;
            case 2:
                self::executeWithoutHandler();
                self::$logger->log("The set up was executed without handler.");
                break;
            default:
                self::$logger->log("The set up of handler was executed incorrect!", ERROR_LEVEL);
                break;
        }
    }

    private static function executeWithHandler(): void
    {
        try {
            Controller::run();

        } catch (Exception | RuntimeException $exception) {
            self::$logger->log($exception, FATAL_LEVEL);
            Router::redirect("/error_pages/incorrect_data.html");
        }
    }

    private static function executeWithoutHandler(): void
    {
        Controller::run();
    }
}