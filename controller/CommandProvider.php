<?php
require_once "./controller/command/CreateCommand.php";
require_once "./controller/command/CreatePageCommand.php";
require_once "./controller/command/ReadAllCommand.php";
require_once "./controller/command/UpdateUserCommand.php";
require_once "./controller/command/UpdateUserPageCommand.php";
require_once "./controller/command/DeleteUserByIdCommand.php";
require_once "./controller/command/DeleteUserByIdPageCommand.php";
require_once "./controller/command/authorization/SignInCommand.php";
require_once "./controller/command/authorization/SignInPageCommand.php";
require_once "./controller/command/authorization/SignOutCommand.php";
require_once "./controller/command/authorization/SignOutPageCommand.php";
require_once "./controller/command/default/DefaultCommand.php";
require_once "./controller/command/CreateAdminCommand.php";
require_once "./controller/command/ProfilePageCommand.php";

class CommandProvider
{

    private static array $command_array = array();
    private static bool $notInit = true;
    private static Logger $logger;

    private function __construct()
    {
    }

    private static function init(): void
    {
        self::$logger = Logger::getLogger();

        self::$command_array[CREATE_USER] = new CreateCommand();
        self::$command_array[CREATE_USER_PAGE] = new CreatePageCommand();
        self::$command_array["/new-admin"] = new CreateAdminCommand();

        self::$command_array["404"] = new ReadAllCommand();

        self::$command_array[UPDATE_USER] = new UpdateUserCommand();
        self::$command_array[DELETE_USER] = new DeleteUserByIdCommand();

        self::$command_array[UPDATE_USER_PAGE] = new UpdateUserPageCommand();
        self::$command_array[DELETE_USER_PAGE] = new DeleteUserByIdPageCommand();

        self::$command_array[LOGIN_PAGE] = new SignInPageCommand();
        self::$command_array[LOGIN] = new SignInCommand();

        self::$command_array[LOGOUT] = new SignOutCommand();
        self::$command_array[LOGOUT_PAGE] = new SignOutPageCommand();

        self::$command_array[HOME_PAGE] = new DefaultCommand();
        self::$command_array[PROFILE_PAGE] = new ProfilePageCommand();

    }

    public static function getCommand($commandName): Command
    {
        if (self::$notInit) {
            self::init();
        }
        $uri = strtolower($commandName);
        if (preg_match("/\?/", $uri)) {
            $uri = stristr($uri, "?", true);
        }

        self::$logger->log($commandName, DEBUG_LEVEL);
        return (array_key_exists($uri, self::$command_array)) ? self::$command_array[$uri] : self::$command_array['404'];
    }


}