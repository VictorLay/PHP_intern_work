<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
error_reporting(E_ALL);
ini_set("display_errors", 1);
spl_autoload_register(function ($className) {
    $className = str_replace("\\", "/", $className);
    include "../" . $className . '.php';
});
require_once "./dependencies.php";
require_once "../app-resources/conf_const.php";
require_once "../app-resources/CustomConstants.php";
require_once "../config/routes.php";
require_once "../app/users/controllers/UserController.php";
//require_once "../app/core/routers/impl/RouterNewImpl.php";
require_once "../config/database/migrations/migrate.php";
$a = new A();
$a->down();
//$a->up();

//if (session_status() == PHP_SESSION_NONE) {
//    session_start();
//}
//
//$uriInfo['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'];
//
//$con = new \app\courses\controllers\CourseController();
//$con->displaySearchPage($uriInfo);



//$query = include "../config/database/migrations/001_create_db_and_tables.php";



//HtmlCoursePageWriter::writeCourseCreateForm();



//$content = new Content(["Some First Text AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA", "Some First Text AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA"], ["222222"], ["333333"]);
//$courseModel = new CourseModelImpl();
//$course = new Course("My Title", 12, $content);
//
//var_dump($content);
//$json = json_encode($content);
//var_dump($json);
//$newCon = new Content();
//$newCon->setContentFieldsWithJson($json);
//var_dump($newCon);
//var_dump($content->jsonSerialize());
//var_dump(json_encode($content));
//$courseModel->create($course);

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
//
//
//$uri = $_SERVER['REQUEST_URI'];
//$router = new Router();
//$router->doSomething($uri);

//"/"; - home
//"/users"; - show all users
//"/users/(userId)"; - userProfile
//"/login"
//"/logout"

