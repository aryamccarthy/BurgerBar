INSERT INTO MenuBurger(name) VALUES
("Burger1"),
("Burger2"),
("Burger3");

INSERT INTO MenuBurger_has_MenuItem VALUES
(1,2),
(1,7),
(1,10),
(1,12),
(1,13),
(1,14),
(1,19),
(1,23),
(1,26),
(2,5),
(2,8),
(2,11);

SELECT idMenuBurger, MenuBurger.name AS burgerName, photoFilePath, idMenuItem, MenuItem.name AS itemName
FROM MenuBurger_has_MenuItem
NATURAL JOIN (MenuBurger, MenuItem);