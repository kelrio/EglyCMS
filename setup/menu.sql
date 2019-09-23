CREATE TABLE IF NOT EXISTS `EglyCMS_menu` (
  `idmenu` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `subelement` INT NULL,
  PRIMARY KEY (`idmenu`))
ENGINE = InnoDB;