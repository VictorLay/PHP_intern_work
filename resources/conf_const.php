<?php
require_once "./bean/User.php";
define("NUM_OF_USERS_ON_ONE_PAGE", 5);

// roles
define("ADMIN", "admin");
define("USER", "user");

define("HOME_URI", "home");
define("PROFILE_URI", "profile");
define("UPDATE_URI", "update");
define("CREATE_URI", "create");
define("DELETE_URI", "delete");
define("LOGIN_URI", "login");
define("USERS_URI", "users");
define("USER_URI", "user");
define("USER_NICKNAME_URI", "user");
define("LOGOUT_URI", "logout");

define("HOME_PAGE", "/" . HOME_URI);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//todo узкое место
if (key_exists('user', $_SESSION)) {
    /** @var User $user */
    $user = $_SESSION['user'];
    define("PROFILE_PAGE", HOME_PAGE . "/" . $user->getId() . "/" . PROFILE_URI);
    define("USER_PAGE", HOME_PAGE . "/" . $user->getId());


} else {
    define("USER_PAGE", HOME_PAGE . "/" . LOGIN_URI);
    define("PROFILE_PAGE", HOME_PAGE . "/" . LOGIN_URI);
}
define("SHOW_ALL_USERS_PAGE", USER_PAGE . "/" . USERS_URI);
define("SHOW_USER_PAGE", SHOW_ALL_USERS_PAGE . "/" . USER_URI);
define("UPDATE_USER_PAGE", PROFILE_PAGE . "/" . UPDATE_URI);
define("UPDATE_ANOTHER_USER_PAGE", SHOW_USER_PAGE."/" . UPDATE_URI);
define("DELETE_USER_PAGE", SHOW_USER_PAGE."/".DELETE_URI);

define("CREATE_USER_PAGE", USER_PAGE . "/" . CREATE_URI);

define("LOGOUT_PAGE", USER_PAGE . "/" . LOGOUT_URI);
define("LOGOUT", "/logoutc");
define("CREATE_USER", HOME_PAGE . "/createc");
//define("UPDATE_USER", "/updatec");


define("DELETE_USER", "/deletec");
define("LOGIN_PAGE", HOME_PAGE . "/" . LOGIN_URI);
//define("LOGIN", "/loginc");


// loggers
define("CONTROLLER", "controller");