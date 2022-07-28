<?php

namespace app\core\models\connection;

use PDO;

class ModelConnection
{
    private static bool $notInit = true;
    private static PDO $connection;

    private function __construct(){
    }

    /**
     * @return PDO
     */
    public static function getConnection(): PDO
    {
        if (self::$notInit){
            self::$connection = new PDO(DB_PROPERTY['dsn'], DB_PROPERTY['username'], DB_PROPERTY['password']);
            self::$notInit = false;
        }

        return self::$connection;
    }



}