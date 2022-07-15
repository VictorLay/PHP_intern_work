<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
//require_once "./dao/impl/UserDaoImplMysql.php";

require_once "./util/handler/Handler.php";
Handler::run(ENGAGE_HANDLER);


//echo "<img src='./resources/default_avatar.jpg'>";

