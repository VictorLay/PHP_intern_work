<?php

return [
    'up' =>
        "-- -----------------------------------------------------
        -- Table `my_db_test_migration`.`courses`
        -- -----------------------------------------------------
        CREATE TABLE IF NOT EXISTS `my_db_test_migration`.`courses` (
          `course_id` INT NOT NULL AUTO_INCREMENT,
          `title` VARCHAR(255) NOT NULL,
          `author_id` INT NOT NULL,
          `content` JSON NOT NULL,
          `deleted` TINYINT NOT NULL DEFAULT '0',
          PRIMARY KEY (`course_id`))
        ENGINE = InnoDB
        AUTO_INCREMENT = 14
        DEFAULT CHARACTER SET = utf8mb4
        COLLATE = utf8mb4_0900_ai_ci;"
    ,
    "down" => "DROP TABLE `my_db_test_migration`.`courses`;"
];