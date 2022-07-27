<?php

/** @link UserController  */
/** @link CourseController */
class Router
{
    private const CONTROLLER = "controller";
    private const ACTION = "action";

    private array $controllerArray = [
        "\/" => [
            self::CONTROLLER => "UserController",
            self::ACTION => "displayHomePage"],
        "\/login" => [
            self::CONTROLLER => "UserController",
            self::ACTION => "displayLoginPage"
        ],
        "\/logout" => [
            self::CONTROLLER => "UserController",
            self::ACTION => "displayLogoutPage"
        ],
        "\/users" => [
            self::CONTROLLER => "UserController",
            self::ACTION => "displayUsersPage"
        ],
        "\/users\/(\d+)" => [
            self::CONTROLLER => "UserController",
            self::ACTION => "displayUserProfilePage"
        ],
        "\/users\/(\d+)\/update" => [
            self::CONTROLLER => "UserController",
            self::ACTION => "displayUpdatePage"
        ],
        "\/users\/(\d+)\/delete" => [
            self::CONTROLLER => "UserController",
            self::ACTION => "displayDeletePage"
        ],
        "\/create" => [
            self::CONTROLLER => "UserController",
            self::ACTION => "displayCreateUserPage"
        ],


        "\/courses" => [
            self::CONTROLLER => "CourseController",
            self::ACTION => "displayUserCoursesPage"
        ],
        "\/courses\/(\d+)" => [
            self::CONTROLLER => "CourseController",
            self::ACTION => "displayCourse"
        ],
        "\/courses\/catalog" => [
            self::CONTROLLER => "CourseController",
            self::ACTION => "displayAllCoursesPage"
        ],
        "\/courses\/(\d+)\/update" => [
            self::CONTROLLER => "CourseController",
            self::ACTION => "displayUpdateCoursePage"
        ],
        "\/courses\/(\d+)\/delete" => [
            self::CONTROLLER => "CourseController",
            self::ACTION => "displayDeleteCoursePage"
        ],
        "\/courses\/create" => [
            self::CONTROLLER => "CourseController",
            self::ACTION => "displayCreateCoursePage"
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
        HtmlUserPageWriter::write404ErrorPage();
    }

}