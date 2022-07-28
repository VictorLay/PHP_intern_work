<?php

return [
    'up'=>
        "-- -----------------------------------------------------
        -- Table `my_db_test_migration`.`users_avatar`
        -- -----------------------------------------------------
        CREATE TABLE IF NOT EXISTS `my_db_test_migration`.`users_avatar` (
          `avatar_id` INT NOT NULL AUTO_INCREMENT,
          `picture_path` VARCHAR(45) NOT NULL,
          PRIMARY KEY (`avatar_id`))
        ENGINE = InnoDB
        AUTO_INCREMENT = 32
        DEFAULT CHARACTER SET = utf8mb4
        COLLATE = utf8mb4_0900_ai_ci;

"
    ,
    "down"=>"DROP TABLE `my_db_test_migration`.`users_avatar`;"
];

/*

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
*/