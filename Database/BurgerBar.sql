-- MySQL Script generated by MySQL Workbench
-- Sun Oct 12 11:43:53 2014
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema BurgerBar
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema BurgerBar
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `BurgerBar` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `BurgerBar` ;

-- -----------------------------------------------------
-- Table `BurgerBar`.`User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `BurgerBar`.`User` ;

CREATE TABLE IF NOT EXISTS `BurgerBar`.`User` (
  `idUser` INT NOT NULL AUTO_INCREMENT COMMENT '	',
  `lName` VARCHAR(45) NULL,
  `fName` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `cardNum` VARCHAR(45) NOT NULL,
  `cardType` VARCHAR(45) NOT NULL,
  `phoneNum` VARCHAR(45) NULL,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  UNIQUE INDEX `password_UNIQUE` (`password` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BurgerBar`.`MenuComponent`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `BurgerBar`.`MenuComponent` ;

CREATE TABLE IF NOT EXISTS `BurgerBar`.`MenuComponent` (
  `idMenuComponent` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `minQuantity` INT NOT NULL,
  `maxQuantity` INT NOT NULL,
  PRIMARY KEY (`idMenuComponent`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BurgerBar`.`MenuItem`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `BurgerBar`.`MenuItem` ;

CREATE TABLE IF NOT EXISTS `BurgerBar`.`MenuItem` (
  `idMenuItem` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL COMMENT '	',
  `price` FLOAT NULL COMMENT '	',
  `isAvailable` TINYINT(1) NULL,
  `MenuComponent_idMenuComponent` INT NOT NULL,
  PRIMARY KEY (`idMenuItem`, `MenuComponent_idMenuComponent`),
  INDEX `fk_MenuItem_MenuComponent1_idx` (`MenuComponent_idMenuComponent` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  CONSTRAINT `fk_MenuItem_MenuComponent1`
    FOREIGN KEY (`MenuComponent_idMenuComponent`)
    REFERENCES `BurgerBar`.`MenuComponent` (`idMenuComponent`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BurgerBar`.`Order`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `BurgerBar`.`Order` ;

CREATE TABLE IF NOT EXISTS `BurgerBar`.`Order` (
  `idOrder` INT NOT NULL AUTO_INCREMENT COMMENT '	',
  `idUser` INT NULL,
  `timestamp` DATETIME NULL,
  `User_idUser` INT NOT NULL,
  PRIMARY KEY (`idOrder`, `User_idUser`),
  INDEX `fk_Order_User1_idx` (`User_idUser` ASC),
  CONSTRAINT `fk_Order_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `BurgerBar`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BurgerBar`.`OrderBurger`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `BurgerBar`.`OrderBurger` ;

CREATE TABLE IF NOT EXISTS `BurgerBar`.`OrderBurger` (
  `idOrderBurger` INT NOT NULL AUTO_INCREMENT,
  `idOrder` INT NULL,
  PRIMARY KEY (`idOrderBurger`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BurgerBar`.`MenuBurger`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `BurgerBar`.`MenuBurger` ;

CREATE TABLE IF NOT EXISTS `BurgerBar`.`MenuBurger` (
  `idMenuBurger` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `photoFilePath` VARCHAR(45) NULL,
  PRIMARY KEY (`idMenuBurger`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BurgerBar`.`MenuBurger_has_MenuItem`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `BurgerBar`.`MenuBurger_has_MenuItem` ;

CREATE TABLE IF NOT EXISTS `BurgerBar`.`MenuBurger_has_MenuItem` (
  `MenuBurger_idMenuBurger` INT NOT NULL,
  `MenuItem_idMenuItem` INT NOT NULL,
  PRIMARY KEY (`MenuBurger_idMenuBurger`, `MenuItem_idMenuItem`),
  INDEX `fk_MenuBurger_has_MenuItem_MenuItem1_idx` (`MenuItem_idMenuItem` ASC),
  INDEX `fk_MenuBurger_has_MenuItem_MenuBurger_idx` (`MenuBurger_idMenuBurger` ASC),
  CONSTRAINT `fk_MenuBurger_has_MenuItem_MenuBurger`
    FOREIGN KEY (`MenuBurger_idMenuBurger`)
    REFERENCES `BurgerBar`.`MenuBurger` (`idMenuBurger`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_MenuBurger_has_MenuItem_MenuItem1`
    FOREIGN KEY (`MenuItem_idMenuItem`)
    REFERENCES `BurgerBar`.`MenuItem` (`idMenuItem`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BurgerBar`.`Order_has_OrderBurger`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `BurgerBar`.`Order_has_OrderBurger` ;

CREATE TABLE IF NOT EXISTS `BurgerBar`.`Order_has_OrderBurger` (
  `Order_idOrder` INT NOT NULL,
  `OrderBurger_idOrderBurger` INT NOT NULL,
  PRIMARY KEY (`Order_idOrder`, `OrderBurger_idOrderBurger`),
  INDEX `fk_Order_has_OrderBurger_OrderBurger1_idx` (`OrderBurger_idOrderBurger` ASC),
  INDEX `fk_Order_has_OrderBurger_Order1_idx` (`Order_idOrder` ASC),
  CONSTRAINT `fk_Order_has_OrderBurger_Order1`
    FOREIGN KEY (`Order_idOrder`)
    REFERENCES `BurgerBar`.`Order` (`idOrder`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Order_has_OrderBurger_OrderBurger1`
    FOREIGN KEY (`OrderBurger_idOrderBurger`)
    REFERENCES `BurgerBar`.`OrderBurger` (`idOrderBurger`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BurgerBar`.`OrderBurger_has_MenuItem`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `BurgerBar`.`OrderBurger_has_MenuItem` ;

CREATE TABLE IF NOT EXISTS `BurgerBar`.`OrderBurger_has_MenuItem` (
  `OrderBurger_idOrderBurger` INT NOT NULL,
  `MenuItem_idMenuItem` INT NOT NULL,
  PRIMARY KEY (`OrderBurger_idOrderBurger`, `MenuItem_idMenuItem`),
  INDEX `fk_OrderBurger_has_MenuItem_MenuItem1_idx` (`MenuItem_idMenuItem` ASC),
  INDEX `fk_OrderBurger_has_MenuItem_OrderBurger1_idx` (`OrderBurger_idOrderBurger` ASC),
  CONSTRAINT `fk_OrderBurger_has_MenuItem_OrderBurger1`
    FOREIGN KEY (`OrderBurger_idOrderBurger`)
    REFERENCES `BurgerBar`.`OrderBurger` (`idOrderBurger`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_OrderBurger_has_MenuItem_MenuItem1`
    FOREIGN KEY (`MenuItem_idMenuItem`)
    REFERENCES `BurgerBar`.`MenuItem` (`idMenuItem`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;