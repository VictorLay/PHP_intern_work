<?php
require_once "./dao/impl/UserDaoImplMysql.php";
require_once "./dao/UserDao.php";

class FactoryDao
{
    //todo how to init constant with static block ar constructor ?
    private static FactoryDao $instance;
    private static bool $notInit = true;
    private UserDao $userDao;

    private function __construct()
    {
        $this->userDao = new UserDaoImplMysql();
    }


    public static function getInstance(): FactoryDao
    {
        if (self::$notInit) {
            self::$instance = new FactoryDao();
            self::$notInit = false;
        }
        return self::$instance;
    }

    public function getUserDao(): UserDao
    {
        return $this->userDao;
    }

}