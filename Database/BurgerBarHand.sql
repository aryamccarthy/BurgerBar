-- Burger Bar Database

DROP DATABASE IF EXISTS BurgerBar;
CREATE DATABASE BurgerBar;
USE BurgerBar;

##
# User
CREATE TABLE BurgerBar.User (
	email VARCHAR(45) NOT NULL,
	lName VARCHAR(45) NULL,
	fName VARCHAR(45) NULL,
	cardNum VARCHAR(45) NULL,
	cardType VARCHAR(45) NULL,
	phoneNum VARCHAR(45) NULL,
	password VARCHAR(45) NULL,
	PRIMARY KEY(email)
);

##
# Menu Component
CREATE TABLE BurgerBar.MenuComponent (
	idMenuComponent INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(45) UNIQUE NOT NULL,
	isSingle  BOOLEAN NOT NULL,
	PRIMARY KEY(idMenuComponent)
);

##
# Menu Item
CREATE TABLE BurgerBar.MenuItem (
	idMenuItem INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(45) UNIQUE NOT NULL, 
	price float NULL,
	isAvailable BOOLEAN DEFAULT TRUE,
	idMenuComponent INT NOT NULL,
	PRIMARY KEY(idMenuItem, idMenuComponent),
	FOREIGN KEY(idMenuComponent) REFERENCES BurgerBar.MenuComponent(idMenuComponent)
);

##
# Menu Component has Menu Item
CREATE TABLE BurgerBar.MenuComponent_has_MenuItem (
	idMenuComponent INT NOT NULL,
	idMenuItem INT NOT NULL,
	PRIMARY KEY(idMenuComponent, idMenuItem),
	FOREIGN KEY(idMenuComponent) REFERENCES BurgerBar.MenuComponent(idMenuComponent),
	FOREIGN KEY(idMenuItem) REFERENCES BurgerBar.MenuItem(idMenuItem)
);

##
# User Order
CREATE TABLE BurgerBar.UserOrder (
	idUserOrder INT NOT NULL AUTO_INCREMENT,
	`timestamp` DATETIME NULL,
	email VARCHAR(45) NOT NULL,
	PRIMARY KEY(idUserOrder, email),
	FOREIGN KEY(email) REFERENCES BurgerBar.User(email)
);

##
# Order Burger
CREATE TABLE BurgerBar.OrderBurger (
	idOrderBurger INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(idOrderBurger)
);

##
# Menu Burger
CREATE TABLE BurgerBar.MenuBurger (
	idMenuBurger INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(45) NULL,
	photoFilePath VARCHAR(45) NULL,
	PRIMARY KEY(idMenuBurger)
);

##
# Menu Burger has Menu Item
CREATE TABLE BurgerBar.MenuBurger_has_MenuItem (
	idMenuBurger INT NOT NULL,
	idMenuItem INT NOT NUll,
	PRIMARY KEY(idMenuBurger, idMenuItem),
	FOREIGN KEY(idMenuBurger) REFERENCES BurgerBar.MenuBurger(idMenuBurger),
	FOREIGN KEY(idMenuItem) REFERENCES BurgerBar.MenuItem(idMenuItem)
);

##
# User Order has Order Burger
CREATE TABLE BurgerBar.UserOrder_has_OrderBurger (
	idUserOrder INT NOT NULL,
	idOrderBurger INT NOT NULL,
	PRIMARY KEY(idUserOrder, idOrderBurger),
	FOREIGN KEY(idUserOrder) REFERENCES BurgerBar.UserOrder(idUserOrder),
	FOREIGN KEY(idOrderBurger) REFERENCES BurgerBar.OrderBurger(idOrderBurger)
);

##
# 







