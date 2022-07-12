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

        self::$command_array["create"] = new CreateCommand();
        self::$command_array["create_page"] = new CreatePageCommand();
        self::$command_array["create_new_admin_user"] = new CreateAdminCommand();

        self::$command_array["show_all_users"] = new ReadAllCommand();

        self::$command_array["update_user_by_id"] = new UpdateUserCommand();
        self::$command_array["delete_user_by_id"] = new DeleteUserByIdCommand();

        self::$command_array["update_user_by_id_page"] = new UpdateUserPageCommand();
        self::$command_array["delete_user_by_id_page"] = new DeleteUserByIdPageCommand();

        self::$command_array["sign_in_page"] = new SignInPageCommand();
        self::$command_array["sign_in"] = new SignInCommand();

        self::$command_array["sign_out"] = new SignOutCommand();
        self::$command_array["sign_out_page"] = new SignOutPageCommand();

        self::$command_array['default'] = new DefaultCommand();

    }

    public static function getCommand($commandName): Command
    {
        if (self::$notInit) {
            self::init();
        }
        if (key_exists('last_command', $_SESSION)){
            $_SESSION['previous_last_command'] = $_SESSION['last_command'];
        }
        $_SESSION['last_command'] = $commandName;
        self::$logger->log($commandName, DEBUG_LEVEL);
        return array_key_exists($commandName, self::$command_array)? self::$command_array[$commandName] : self::$command_array['default'];
    }



}