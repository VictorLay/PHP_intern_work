<?php
require_once "./dependencies.php";
error_reporting(E_ALL);
ini_set("display_errors", 1);
//require_once "./util/HtmlPageWriter.php";
//require_once "./bean/User.php";
//require_once "./resources/conf_const.php";
//require_once "./bean/Course.php";
//require_once "./dao/impl/CourseDaoImplMysql.php";

//$content =
//    new Content(
//        ["First Text","Second Text","Third Text"],
//        ["link1","link2","link13"],
//        ["linkVideo1","linkVideo2","linkVideo3"]);
//$course = new Course("UpdateTest", 12, $content);
//$course->setId(1);
//echo CourseContentInterpreter::parseContentToJson($content);
//var_dump(json_encode($content));
//var_dump(json_decode(json_encode($content),JSON_OBJECT_AS_ARRAY));
//var_dump(json_encode($content));
//$content->setContentFieldsWithJson(json_encode($content));
//var_dump($content);

//echo file_get_contents("http://localhost/home");
//
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
var_dump($_SESSION['user']);
/** @var User $sessionUser */
$sessionUser = $_SESSION['user'];
var_dump($sessionUser);
echo $sessionUser->getId();

//unset($_SESSION['user']);

//var_dump(json_decode(json_encode($content), JSON_OBJECT_AS_ARRAY));

//    $courseDao = new CourseDaoImplMysql();
//    $courseDao->updateCourse($course);
//    echo $courseDao->create($course);
//    $course = $courseDao->readCourseById(1);
//    $course = $courseDao->readCoursesByAuthorId(122);
//    $course = $courseDao->readCoursesBySameTitle("ig");
//    var_dump($course);

//echo json_encode([
//    [
//    "type"=>"article",
//    "value"=>"125"
//]
//]);
//if (key_exists('picture', $_FILES)) {1
//    if (@copy($_FILES['picture']['tmp_name'], "./resources/" . $_FILES['picture']['name'])) {
//        echo "COOOOOL!";
//    }else{
//        echo "Bed!";
//    }
//}