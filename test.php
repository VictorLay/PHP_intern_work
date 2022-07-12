<!--<form enctype="multipart/form-data" method="post">-->
<!--    <input name="picture" type="file" />-->
<!--    <input type="submit" value="Загрузить" />-->
<!--</form>-->
<!--<img src="/var/www/html/resources/dima.jpeg"/>-->
<!--<img src="./resources/dima.jpeg"/>-->
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once "./bean/User.php";
require_once "./service/impl/UserServiceImpl.php";

//require_once ""


try {
    if (key_exists("i", $_GET)) {
        $num = $_GET['i'];
        $userService = new UserServiceImpl();
        for (;$num<($_GET['i']+50);$num++){
            $user = new User();
            $user->setAvatarPath("./resources/default_avatar.jpg");
            $user->setEmail("User".$num."@mail.ru");
            $user->setName("Bill".$num);
            $user->setCountry("USA".$num);
            $user->setRole("user");
//          $user->setId();

            $userService->create($user);
        }
        header("location: http://localhost/lol.php?i=".($num + 1));
    }

}catch (Exception $exception){
    echo $exception;
}





//error_reporting(E_ALL);
//ini_set("display_errors", 1);
// "/var/www/html/logs/";
//
////<img src="../../../media/avatar/dima.jpeg"/>
//
//$path = '/var/www/html/resources/';
//
//if ($_SERVER['REQUEST_METHOD'] == 'POST')
//{
//    if (!@copy($_FILES['picture']['tmp_name'], $path . $_FILES['picture']['name']))
//        echo 'Что-то пошло не так';
//    else
//        echo 'Загрузка удачна';
//
//
//}
//$tp = fopen( $path ."test.jpg", 'a+');
//
//echo "XD";


//error_reporting(E_ALL);
//ini_set("display_errors", 1);
//require_once "./util/validation/impl/UserValidator.php";
//
//$mail = $_POST['mail'];
//
//echo "<form action='/test.php' method='post'>
//<input type='text' name='mail' value='" . $mail . "'/ >
//<input type='submit' value='check mail'/>
//</form>";
//
//$validator = new UserValidator();
//if ($validator->isValidMail($mail)) {
//    echo "<h1>VALID</h1>";
//} else {
//    echo "<h1>INVALID</h1>";
//
//}