<?php

class ServiceFactory{
    private static ServiceFactory $instance;
    private static bool $notInit = true;
    private UserService $userService;
    private CourseService $courseService;

    private function __construct()
    {
        $this->userService = new UserServiceImpl();
        $this->courseService = new CourseServiceImpl();
    }


    public static function getInstance(): ServiceFactory
    {
        if (self::$notInit) {
            self::$instance = new ServiceFactory();
            self::$notInit = false;
        }
        return self::$instance;
    }

    public function getUserService(): UserService
    {
        return $this->userService;
    }

    public function getCourseService(): CourseService|CourseServiceImpl
    {
        return $this->courseService;
    }
}