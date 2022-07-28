<?php

return [
    'up'=>
        "-- -----------------------------------------------------
        -- Table `my_db_test_migration`.`user_role`
        -- -----------------------------------------------------
        CREATE TABLE IF NOT EXISTS `my_db_test_migration`.`user_role` (
          `user_id` INT NOT NULL,
          `role_id` VARCHAR(45) NOT NULL,
          PRIMARY KEY (`user_id`, `role_id`))
        ENGINE = InnoDB
        DEFAULT CHARACTER SET = utf8mb4
        COLLATE = utf8mb4_0900_ai_ci;"
    ,
    "down"=>"DROP TABLE `my_db_test_migration`.`user_role`;"
];