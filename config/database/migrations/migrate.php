<?php

class A extends \app\core\models\TransactionImpl
{
    public function up(): void
    {
        $result = glob("../config/database/migrations/[0-9][0-9][0-9]*.php");
        $i = 0;
        while (@is_file($result[$i]) && $i < count($result)) {
            echo " {$result[$i]} <br>";
//            $fileContents = file_get_contents($result[$i]);
            $query = (include "migrate.php");
            try {
                $statement = $this->connection->prepare($query['up']);
                $statement->execute();
            } catch (Exception $r) {
                die("No");
            }
            $i++;
        }
    }

    public function down(): void
    {
        $result = glob("../config/database/migrations/[0-9][0-9][0-9]*.php");
        $i = count($result) - 1;
        while (@is_file($result[$i]) && $i >= 0) {
            echo " {$result[$i]} <br>";
            $query = (include "migrate.php");
            try {
                $statement = $this->connection->prepare($query['down']);
                $statement->execute();
            } catch (Exception $r) {
                die("No");
            }
            echo " {$query['down']} <br>";

            $i--;
        }
    }
}

