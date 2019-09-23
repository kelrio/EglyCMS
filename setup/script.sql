-- -----------------------------------------------------
-- Table `EglyCMS_menu`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EglyCMS_menu` (
  `idmenu` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `subelement` INT NULL,
  PRIMARY KEY (`idmenu`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EglyCMS_image`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EglyCMS_image` (
  `idimage` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(35) NOT NULL,
  `type` VARCHAR(3) NOT NULL,
  PRIMARY KEY (`idimage`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EglyCMS_imageOnPage`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EglyCMS_imageOnPage` (
  `idimageOnPage` INT NOT NULL AUTO_INCREMENT,
  `image_idimage` INT NOT NULL,
  `description` VARCHAR(500) NULL,
  PRIMARY KEY (`idimageOnPage`),
  INDEX `fk_imageOnPage_image1_idx` (`image_idimage` ASC),
  CONSTRAINT `fk_imageOnPage_image1`
    FOREIGN KEY (`image_idimage`)
    REFERENCES `EglyCMS_image` (`idimage`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EglyCMS_textOnPage`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EglyCMS_textOnPage` (
  `idtextOnPage` INT NOT NULL AUTO_INCREMENT,
  `text` LONGTEXT NOT NULL,
  PRIMARY KEY (`idtextOnPage`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EglyCMS_page`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EglyCMS_page` (
  `idpage` INT NOT NULL AUTO_INCREMENT,
  `menu_idmenu` INT NOT NULL,
  `imageOnPage_idimageOnPage` INT NULL,
  `textOnPage_idtextOnPage` INT NULL,
  `orders` INT(3) NOT NULL,
  PRIMARY KEY (`idpage`, `menu_idmenu`),
  INDEX `fk_page_menu1_idx` (`menu_idmenu` ASC),
  INDEX `fk_page_imageOnPage1_idx` (`imageOnPage_idimageOnPage` ASC),
  INDEX `fk_page_textOnPage1_idx` (`textOnPage_idtextOnPage` ASC),
  CONSTRAINT `fk_page_menu1`
    FOREIGN KEY (`menu_idmenu`)
    REFERENCES `EglyCMS_menu` (`idmenu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_page_imageOnPage1`
    FOREIGN KEY (`imageOnPage_idimageOnPage`)
    REFERENCES `EglyCMS_imageOnPage` (`idimageOnPage`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_page_textOnPage1`
    FOREIGN KEY (`textOnPage_idtextOnPage`)
    REFERENCES `EglyCMS_textOnPage` (`idtextOnPage`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EglyCMS_setting`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EglyCMS_setting` (
  `idsetting` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `value` VARCHAR(250) NOT NULL,
  `group` VARCHAR(40) NULL,
  `options` VARCHAR(500) NULL,
  PRIMARY KEY (`idsetting`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EglyCMS_user`
-- -----------------------------------------------------
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