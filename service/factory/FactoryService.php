<?php
require_once "./service/impl/UserServiceImpl.php";

class FactoryService
{
    private static FactoryService $instance;
    private static bool $notInit = true;
    private UserService $userService;

    private function __construct()
    {
        $this->userService = new UserServiceImpl();
    }


    public static function getInstance(): FactoryService
    {
        if (self::$notInit) {
            self::$instance = new FactoryService();
            self::$notInit = false;
        }
        return self::$instance;
    }

    public function getUserService(): UserService
    {
        return $this->userService;
    }
}