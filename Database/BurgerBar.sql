-- MySQL Script generated by MySQL Workbench
-- Fri Oct 17 17:21:43 2014
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
  `email` VARCHAR(45) NULL,
  `lName` VARCHAR(45) NULL,
  `fName` VARCHAR(45) NULL,
  `cardNum` VARCHAR(45) NULL,
  `cardType` VARCHAR(45) NULL,
  `phoneNum` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  PRIMARY KEY (`email`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BurgerBar`.`MenuComponent`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `BurgerBar`.`MenuComponent` ;

CREATE TABLE IF NOT EXISTS `BurgerBar`.`MenuComponent` (
  `idMenuComponent` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `isLimitOne` TINYINT(1) NULL,
  PRIMARY KEY (`idMenuComponent`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BurgerBar`.`MenuItem`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `BurgerBar`.`MenuItem` ;

CREATE TABLE IF NOT EXISTS `BurgerBar`.`MenuItem` (
  `idMenuItem` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL COMMENT '	',
  `price` FLOAT NULL COMMENT '	',
  `available` TINYINT(1) NULL,
  `idMenuComponent` INT NOT NULL,
  PRIMARY KEY (`idMenuItem`, `idMenuComponent`),
  INDEX `fk_MenuItem_MenuComponent1_idx` (`idMenuComponent` ASC),
  CONSTRAINT `fk_MenuItem_MenuComponent1`
    FOREIGN KEY (`idMenuComponent`)
    REFERENCES `BurgerBar`.`MenuComponent` (`idMenuComponent`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BurgerBar`.`UserOrder`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `BurgerBar`.`UserOrder` ;

CREATE TABLE IF NOT EXISTS `BurgerBar`.`UserOrder` (
  `idUserOrder` INT NOT NULL AUTO_INCREMENT COMMENT '	',
  `timestamp` DATETIME NULL,
  `email` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idUserOrder`, `email`),
  INDEX `fk_UserOrder_User1_idx` (`email` ASC),
  CONSTRAINT `fk_UserOrder_User1`
    FOREIGN KEY (`email`)
    REFERENCES `BurgerBar`.`User` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BurgerBar`.`OrderBurger`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `BurgerBar`.`OrderBurger` ;

CREATE TABLE IF NOT EXISTS `BurgerBar`.`OrderBurger` (
  `idOrderBurger` INT NOT NULL AUTO_INCREMENT,
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
  `idMenuBurger` INT NOT NULL,
  `idMenuItem` INT NOT NULL,
  PRIMARY KEY (`idMenuBurger`, `idMenuItem`),
  INDEX `fk_MenuBurger_has_MenuItem_MenuItem1_idx` (`idMenuItem` ASC),
  INDEX `fk_MenuBurger_has_MenuItem_MenuBurger_idx` (`idMenuBurger` ASC),
  CONSTRAINT `fk_MenuBurger_has_MenuItem_MenuBurger`
    FOREIGN KEY (`idMenuBurger`)
    REFERENCES `BurgerBar`.`MenuBurger` (`idMenuBurger`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_MenuBurger_has_MenuItem_MenuItem1`
    FOREIGN KEY (`idMenuItem`)
    REFERENCES `BurgerBar`.`MenuItem` (`idMenuItem`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BurgerBar`.`Order_has_OrderBurger`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `BurgerBar`.`Order_has_OrderBurger` ;

CREATE TABLE IF NOT EXISTS `BurgerBar`.`Order_has_OrderBurger` (
  `idUserOrder` INT NOT NULL,
  `idOrderBurger` INT NOT NULL,
  PRIMARY KEY (`idUserOrder`, `idOrderBurger`),
  INDEX `fk_Order_has_OrderBurger_OrderBurger1_idx` (`idOrderBurger` ASC),
  INDEX `fk_Order_has_OrderBurger_Order1_idx` (`idUserOrder` ASC),
  CONSTRAINT `fk_Order_has_OrderBurger_Order1`
    FOREIGN KEY (`idUserOrder`)
    REFERENCES `BurgerBar`.`UserOrder` (`idUserOrder`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Order_has_OrderBurger_OrderBurger1`
    FOREIGN KEY (`idOrderBurger`)
    REFERENCES `BurgerBar`.`OrderBurger` (`idOrderBurger`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BurgerBar`.`OrderBurger_has_MenuItem`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `BurgerBar`.`OrderBurger_has_MenuItem` ;

CREATE TABLE IF NOT EXISTS `BurgerBar`.`OrderBurger_has_MenuItem` (
  `idOrderBurger` INT NOT NULL,
  `idMenuItem` INT NOT NULL,
  PRIMARY KEY (`idOrderBurger`, `idMenuItem`),
  INDEX `fk_OrderBurger_has_MenuItem_MenuItem1_idx` (`idMenuItem` ASC),
  INDEX `fk_OrderBurger_has_MenuItem_OrderBurger1_idx` (`idOrderBurger` ASC),
  CONSTRAINT `fk_OrderBurger_has_MenuItem_OrderBurger1`
    FOREIGN KEY (`idOrderBurger`)
    REFERENCES `BurgerBar`.`OrderBurger` (`idOrderBurger`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_OrderBurger_has_MenuItem_MenuItem1`
    FOREIGN KEY (`idMenuItem`)
    REFERENCES `BurgerBar`.`MenuItem` (`idMenuItem`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
