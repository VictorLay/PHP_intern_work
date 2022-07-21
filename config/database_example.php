<?php

$dbHostAddress = "localhost";
$dbName = 'your_db_name';
$userName = "root";
$password = "password_for_your_connection";
$dbCharset = "utf8";

return [
    'dsn' => "mysql:host=$dbHostAddress;dbname=$dbName;charset=$dbCharset",
    'username' => "$userName",
    'password' => "$password"
];