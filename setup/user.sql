CREATE TABLE IF NOT EXISTS `EglyCMS_user` (
  `iduser` INT NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(45) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  `editArticle` TINYINT NOT NULL,
  `createPage` TINYINT NOT NULL,
  `changeSetting` TINYINT NOT NULL,
  `changeAccount` TINYINT NOT NULL,
  `delete` VARCHAR(3) NULL,
  PRIMARY KEY (`iduser`))
ENGINE = InnoDB;