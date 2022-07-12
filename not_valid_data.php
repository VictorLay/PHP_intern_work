<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once "./bean/User.php";

//require_once "./bean/User.php";

echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Validation mistake</title>
</head>
<body>
<h5>You set wrong data in the field. Please try again.!</h5>
<form action="http://localhost//" method="post">
<input type="submit" value="back">
<input type="hidden" name="command" value="';

session_start();
if (key_exists("previous_last_command", $_SESSION)) {
    echo $_SESSION['previous_last_command'];
}
echo '"/>';
/** @var User $notValidUser */
$notValidUser = $_SESSION['not_valid_user_data'];

echo " <br/><input type='hidden' name='user_email' value='" . $notValidUser->getEmail() . "'/>
            <input type='hidden' name='user_country' value='" . $notValidUser->getCountry() . "'/>
            <input type='hidden' name='user_name' value='" . $notValidUser->getName() . "'/>
            <input type='hidden' name='user_id' value='" . $notValidUser->getId() . "'/>
            <input type='hidden' name='user_role' value='" . $notValidUser->getRole() . "'/>
           </form>
</body>
</html>";


