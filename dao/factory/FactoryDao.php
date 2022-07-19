<?php
require_once "./dao/impl/UserDaoImplMysql.php";
require_once "./dao/UserDao.php";
require_once "./dao/CourseDao.php";

class FactoryDao
{
    private static FactoryDao $instance;
    private static bool $notInit = true;
    private UserDao $userDao;
    private CourseDao $courseDao;

    private function __construct()
    {
        $this->userDao = new UserDaoImplMysql();
        $this->courseDao = new CourseDaoImplMysql();
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

    public function getCourseDao(): CourseDaoImplMysql|CourseDao
    {
        return $this->courseDao;
    }

}