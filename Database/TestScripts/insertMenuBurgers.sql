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

Insert Into User Values
("drizzuto@smu.edu", "Rizzuto", "Daniel", "MasterCard", "Credit", "2032472705", "Good1234"), 
("zfout@smu.edu", "Fout", "Zack", "MasterCard", "Credit", "2032472222", "Good1234");

Insert Into UserOrder Values
(0001, NOW(), "drizzuto@smu.edu"),
(0002, NOW(), "drizzuto@smu.edu"),
(0003, NOW(), "zfout@smu.edu");

Insert Into OrderBurger Values
(0001),
(0002),
(0003);

Insert Into Order_has_OrderBurger Values 
(0001, 0001),
(0002, 0002),
(0003, 0003);

Daniel Rizzuto
203-247-2705
dgrsoccer@gmail.com


SELECT MenuComponent.idMenuComponent, MenuComponent.name, idMenuItem, MenuItem.name, price
FROM MenuItem
JOIN MenuComponent
ON (MenuItem.idMenuComponent= MenuComponent.idMenuComponent);
