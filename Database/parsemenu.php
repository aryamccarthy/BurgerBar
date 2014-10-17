<!--

parsemenu.php

Function: Populates the menu of the BurgerBar database with data from a JSON file.

Contrubutors: Zach Fout, Luke Oglesbee

Futre work:
  - DOES NOT HANDLE MIN AND MAX VALUE FOR A COMPONENT. This information is not in the
  	menu.json, so we need to figure out how we put that in...
  - Give some kind of permission rights to this file. Right now anyone can
 	go to this url and this script will run.
  - Check if the menu is already filled in the database. This could update the menu
	by changing the price of menu items alrday in the database and changing items not
	found to unavailable.

-->

<?php

	function getDBConnection() { #connects to sql database
	    try {
	    	//127.0.0.1
	         $pdo = new PDO("mysql:host=localhost;dbname=BurgerBar", 
			"root", "3.00x10^8m/s");
		} catch (PDOException $e) {
			$response = "Failed to connect: ";
			$response .= $e->getMessage();
			die($response);
		}

		echo "Successfully connected to BurgerBar Database!<br><br>";
		return $pdo;
	}

	function getMenuItems($file_name) { #parses menu in json format
		$json = file_get_contents($file_name);
		return json_decode($json, $assoc=True)["menu"];
	}

	function buildItemInfo($pdo, $menu) {
		$insertComp = $pdo->prepare(
			"INSERT INTO MenuComponent(name, minQuantity, maxQuantity)
			VALUES(:name, :minQuantity, :maxQuantity);"
		);
		$insertComp->bindParam(':name', $component);
		$insertComp->bindValue(':minQuantity', 1);
		$insertComp->bindValue(':maxQuantity', 1);
		
		$insertItem = $pdo->prepare(
			"INSERT INTO MenuItem(name, price, available, idMenuComponent)
			VALUES (:name, :price, :available, :menuComponentID);"
		);
		$insertItem->bindParam(':name', $name);
		$insertItem->bindParam(':price', $price);
		$insertItem->bindValue(':available', True);
		$insertItem->bindParam(':menuComponentID', $compID);

		$lastID = $pdo->prepare("SELECT LAST_INSERT_ID();");

		foreach ($menu as $component => $items) {
			echo "$component: ";
			if ($insertComp->execute()) {
				echo "success </br>";
			} else {
				echo "fail </br>";
			}

			if ($lastID->execute()) {
				$compID = $lastID->fetch()["LAST_INSERT_ID()"];
				var_dump($compID);
				echo "</br>";
			} else {
				echo "</br>Didn't work...</br>";
			}

			foreach ($items as $item) {
				$name = $item["name"];
				$price = $item["price"];
				echo "--- ".$name.": ";
				if ($insertItem->execute()) {
					echo "success </br>";
				} else {
					echo "fail </br>";
					$errorData = $insertItem->errorInfo();
					echo $errorData[2];
					echo "</br>";
				}
			}
		}
	}

        function buildOrder($pdo, $file_name) {
            $json = file_get_contents($file_name);
            $order = json_decode($json, true);
            $userEmail = $order['email'];
            $timeStamp = $order['order']['timeStamp'];
            $burgers = $order['order']['burgers'];
            $orderBurgerIds = array();
            $orderId = 0;

            $lName = 'Laugia';
            $fName = 'Robert';
            $cardNum = '12345678';
            $cardType = 'Visa';
            $phoneNum = '1234';
            $password = 'pass';            
 
            $insertUser = $pdo->prepare(
                "INSERT INTO User(email, lName, fName, cardNum, 
                cardType, PhoneNum, password)
                VALUES(:email, :lName, :fName, :cardNum, :cardType, :phoneNum, :password)"
            );
            $insertUser->bindParam(':email', $userEmail);
            $insertUser->bindParam(':lName', $lName);
            $insertUser->bindParam(':fName', $fName);
            $insertUser->bindParam(':cardNum', $cardNum);
            $insertUser->bindParam(':cardType', $cardType);
            $insertUser->bindParam(':phoneNum', $phoneNum);
            $insertUser->bindParam(':password', $password);

            if ($insertUser->execute()) {
                echo "Successfully inserted int User<br>";
            } else {
                  echo "fail<br>";
                  $errorData = $insertUser->errorInfo();
                  echo $errorData[2] . "<br>";
            }

            $insertOrder = $pdo->prepare(
                "INSERT INTO UserOrder(timestamp, email)
                VALUES(:timestamp, :email)"
            );
            $insertOrder->bindParam(':timestamp', $timeStamp);
            $insertOrder->bindParam(':email', $userEmail);

            if ($insertOrder->execute()) {
                echo "Successfully inserted int UserOrder<br>";
            } else {
                  echo "fail<br>";
                  $errorData = $insertOrder->errorInfo();
                  echo $errorData[2] . "<br>";
            } 

            foreach ($burgers as $burger) {
               $insertOrderBurger = $pdo->prepare(
                   "INSERT INTO OrderBurger(idOrderBurger)
                   VALUES (NULL)"
                );

                if ($insertOrderBurger->execute()) {
                     echo "success<br>";
                } else {
                      echo "fail<br>";
                      $errorData = $insertOrderBurger->errorInfo();
                      echo $errorData[2] . "<br>";
                }
            }

            $orderBurgers = $pdo->prepare("SELECT idOrderBurger FROM OrderBurger");
            if ($orderBurgers->execute()) {
                 echo "successfully accessed OrderBurger<br>";
                 while($row = $orderBurgers->fetch()) {
                     array_push($orderBurgerIds, $row['idOrderBurger']);
                 }
            } else {
                  echo "fail<br>";
                  $errorData = $orderBurgers->errorInfo();
	          echo $errorData[2] . "<br>";
            }

            $getOrderId = $pdo->prepare(
                "SELECT idUserOrder FROM UserOrder
                WHERE email = :email AND timestamp = :timestamp
            ");
             $getOrderId->bindParam(':email', $userEmail); 
             $getOrderId->bindParam(':timestamp', $timeStamp);

            if ($getOrderId->execute()) {
                echo "successfully accessed UserOrder<br>";
                while($row = $getOrderId->fetch()) {
                    $orderId = $row['idUserOrder'];
                }
            }
    
            foreach ($burgers as $burger => $ingredients) {
                $insertHasOrderBurger = $pdo->prepare(
                    "INSERT INTO Order_has_OrderBurger(idUserOrder, idOrderBurger)
                    VALUES(:idUserOrder, :idOrderBurger)"
                    );
                    $insertHasOrderBurger->bindParam(':idUserOrder', $orderId);
                    $insertHasOrderBurger->bindParam('idOrderBurger', $orderBurgerIds[$burger]);                        

                    if ($insertHasOrderBurger->execute()) {
                        echo "successfully inserted into OrderBurger_has_OrderBurger<br>";
                    } else {
                          echo "fail<br>";
                          $errorData = $insertHasOrderBurger->errorInfo();
                          echo $errorData[2] . "<br>";
                    }
 
                foreach ($ingredients as $id => $toppingObj) {
                    foreach ($toppingObj as $item => $id) {
                        $insertOrderBurger = $pdo->prepare(
                            "INSERT INTO OrderBurger_has_MenuItem(idOrderBurger, idMenuItem) 
                            VALUES(:idOrderBurger, :idMenuItem)"
                         );
                         $insertOrderBurger->bindParam(':idOrderBurger', $orderBurgerIds[$burger]);
                         $insertOrderBurger->bindParam(':idMenuItem', $id);
                         
                         if ($insertOrderBurger->execute()) {
                              echo "successfully inserted into OrderBurger_has_MenuItem<br>";
                         } else {
                                echo "fail<br>";
                                $errorData = $insertOrderBurger->errorInfo();
                                echo $errorData[2] . "<br>";
                         }
                    }
                }
            }
        }

	$menu_loc = "./menu.json";
        $order_loc = "./order.json";
	$menu = getMenuItems($menu_loc);
	$pdo = getDBConnection();
        buildItemInfo($pdo, $menu);
        $order = buildOrder($pdo, $order_loc);	
        
?>
