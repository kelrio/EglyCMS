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