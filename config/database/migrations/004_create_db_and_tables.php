<?php

return [
    'up'=>
        "-- -----------------------------------------------------
        -- Table `my_db_test_migration`.`users`
        -- -----------------------------------------------------
        CREATE TABLE IF NOT EXISTS `my_db_test_migration`.`users` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `email` VARCHAR(45) NOT NULL,
          `country` VARCHAR(45) NOT NULL,
          `name` VARCHAR(45) NOT NULL,
          `password` VARCHAR(255) NOT NULL,
          `deleted` TINYINT NOT NULL,
          `avatar_id` INT NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
        ENGINE = InnoDB
        AUTO_INCREMENT = 740
        DEFAULT CHARACTER SET = utf8mb4
        COLLATE = utf8mb4_0900_ai_ci;"
    ,
    "down"=>"DROP TABLE `my_db_test_migration`.`users`;"
];