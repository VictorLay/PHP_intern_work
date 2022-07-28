<?php

namespace app\core\routers;

use app\core\views\CoreHtmlPageWriter;

/** @link UserController  */
/** @link CourseController */
class Router
{
    private const CONTROLLER = "controller";
    private const ACTION = "action";

    private array $controllerArray = [
        "\/" => [
            self::CONTROLLER => "app\users\controllers\UserController",
            self::ACTION => "displayHomePage"],
        "\/login" => [
            self::CONTROLLER => "app\users\controllers\UserController",
            self::ACTION => "displayLoginPage"
        ],
        "\/logout" => [
            self::CONTROLLER => "app\users\controllers\UserController",
            self::ACTION => "displayLogoutPage"
        ],
        "\/users" => [
            self::CONTROLLER => "app\users\controllers\UserController",
            self::ACTION => "displayUsersPage"
        ],
        "\/users\/(\d+)" => [
            self::CONTROLLER => "app\users\controllers\UserController",
            self::ACTION => "displayUserProfilePage"
        ],
        "\/users\/(\d+)\/update" => [
            self::CONTROLLER => "app\users\controllers\UserController",
            self::ACTION => "displayUpdatePage"
        ],
        "\/users\/(\d+)\/delete" => [
            self::CONTROLLER => "app\users\controllers\UserController",
            self::ACTION => "displayDeletePage"
        ],
        "\/create" => [
            self::CONTROLLER => "app\users\controllers\UserController",
            self::ACTION => "displayCreateUserPage"
        ],


        "\/courses" => [
            self::CONTROLLER => "app\courses\controllers\CourseController",
            self::ACTION => "displayUserCoursesPage"
        ],
        "\/courses\/(\d+)" => [
            self::CONTROLLER => "app\courses\controllers\CourseController",
            self::ACTION => "displayCourse"
        ],
        "\/courses\/catalog" => [
            self::CONTROLLER => "app\courses\controllers\CourseController",
            self::ACTION => "displayAllCoursesPage"
        ],
        "\/courses\/(\d+)\/update" => [
            self::CONTROLLER => "app\courses\controllers\CourseController",
            self::ACTION => "displayUpdateCoursePage"
        ],
        "\/courses\/(\d+)\/delete" => [
            self::CONTROLLER => "app\courses\controllers\CourseController",
            self::ACTION => "displayDeleteCoursePage"
        ],
        "\/courses\/create" => [
            self::CONTROLLER => "app\courses\controllers\CourseController",
            self::ACTION => "displayCreateCoursePage"
        ],
        "\/courses\/search" => [
            self::CONTROLLER => "app\courses\controllers\CourseController",
            self::ACTION => "displaySearchPage"
        ],
        "\/courses\/recover" => [
            self::CONTROLLER => "app\courses\controllers\CourseController",
            self::ACTION => "displayDeletedCourses"
        ]


    ];

    public function doSomething(string $uri):void
    {
        foreach ($this->controllerArray as $key=>$item){
            $uriInfo =[];
            if (preg_match("/^$key$/",$uri,$uriInfo)){
                $uriInfo['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'];

                $controller = new $item[self::CONTROLLER]();
                $action = $item[self::ACTION];

                $controller->$action($uriInfo);
                return;
            }
        }
        /* Если не найдено ни одно совпадение, то возвращается Html 404 страницы */
        CoreHtmlPageWriter::write404ErrorPage();
    }

}