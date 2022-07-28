<?php

return [
    'up'=>
        "-- -----------------------------------------------------
        -- Table `my_db_test_migration`.`roles`
        -- -----------------------------------------------------
        CREATE TABLE IF NOT EXISTS `my_db_test_migration`.`roles` (
          `role_id` INT NOT NULL,
          `role` VARCHAR(45) NOT NULL,
          PRIMARY KEY (`role_id`))
        ENGINE = InnoDB
        DEFAULT CHARACTER SET = utf8mb4
        COLLATE = utf8mb4_0900_ai_ci;"
    ,
    "down" => "DROP TABLE `my_db_test_migration`.`roles`;"

];