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