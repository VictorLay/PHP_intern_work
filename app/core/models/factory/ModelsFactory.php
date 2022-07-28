<?php

namespace app\core\models\factory;

use app\users\models\UserModel;
use app\courses\models\CourseModel;
use app\users\models\impl\UserModelImpl;
use app\courses\models\impl\CourseModelImpl;

class ModelsFactory
{
    private static ModelsFactory $instance;
    private static bool $notInit = true;
    private UserModel $userDao;
    private CourseModel $courseDao;

    private function __construct()
    {
        $this->userDao = new UserModelImpl();
        $this->courseDao = new CourseModelImpl();
    }

    public static function getInstance(): ModelsFactory
    {
        if (self::$notInit) {
            self::$instance = new ModelsFactory();
            self::$notInit = false;
        }
        return self::$instance;
    }

    public function getUserDao(): UserModel
    {
        return $this->userDao;
    }



    public function getCourseDao(): CourseModel
    {
        return $this->courseDao;
    }

}