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
(1,26);

SELECT name, MenuBurger_idMenuBurger, MenuItem_idMenuItem
FROM MenuBurger
LEFT JOIN MenuBurger_has_MenuItem
ON (MenuBurger.idMenuBurger, MenuBurger_has_MenuItem.MenuBurger_idMenuBurger)
ORDER BY IdBurger;

SELECT MenuBurger.name as burgerName, MenuItem_idMenuItem as idItem, idMenuItem as IdItem
FROM MenuBurger
JOIN MenuBurger_has_MenuItem
ON (MenuBurger.idMenuBurger=MenuBurger_has_MenuItem.MenuBurger_idMenuBurger)
JOIN MenuItem
ON (MenuBurger_has_MenuItem.MenuBurger_idMenuBurger = MenuItem.idMenuItem);

SELECT MenuBurger.name, MenuItem.name
FROM MenuBurger_has_MenuItem
NATURAL JOIN (MenuBurger, MenuItem);