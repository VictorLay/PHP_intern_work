<?php

use app\core\bootstrap\App;

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

$app = new App();
$app->run();