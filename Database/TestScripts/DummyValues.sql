Insert Into User 
	Values
		("drizzuto@smu.edu", "Rizzuto", "Daniel", "MasterCard", "Credit", "2032472705", "Good1234"), 
		("zfout@smu.edu", "Fout", "Zack", "MasterCard", "Credit", "2032472222", "Good1234");

Insert Into UserOrder
	Values
    (0001, NOW(), "drizzuto@smu.edu"),
    (0002, NOW(), "drizzuto@smu.edu"),
    (0003, NOW(), "zfout@smu.edu");
    
Insert Into OrderBurger
	Values
		(0001),
        (0002),
        (0003);
    
Insert Into Order_has_OrderBurger
	Values 
		(0001, 0001),
        (0002, 0002),
        (0003, 0003);