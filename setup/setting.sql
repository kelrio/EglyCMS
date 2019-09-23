CREATE TABLE IF NOT EXISTS `EglyCMS_setting` (
  `idsetting` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `value` VARCHAR(250) NOT NULL,
  `group` VARCHAR(40) NULL,
  `options` VARCHAR(500) NULL,
  PRIMARY KEY (`idsetting`))
ENGINE = InnoDB;