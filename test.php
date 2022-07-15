<form action='/test.php' method='post' enctype='multipart/form-data'><br/>
    <input type='file' name='picture'/>
    <input type='submit' value='update write'/><br/>
</form><br/>

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once "./util/HtmlPageWriter.php";
require_once "./bean/User.php";
require_once "./resources/conf_const.php";


if (key_exists('picture', $_FILES)) {
    if (@copy($_FILES['picture']['tmp_name'], "./resources/" . $_FILES['picture']['name'])) {
        echo "COOOOOL!";
    }else{
        echo "Bed!";
    }
}