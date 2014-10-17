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
			$pdo = new PDO("mysql:host=localhost;dbname=BurgerBar", 
				"root", "<password>");
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
			"INSERT INTO MenuItem(name, price, available, MenuComponent_idMenuComponent)
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
            $email = $order['email'];
            $timeStamp = $order['order']['timeStamp'];
            $burgers = $order['order']['burgers'];
            $burgerIds = array();

            foreach ($burgers as $burger => $ingredients) {
                array_push($burgerIds, $burger);
            }

            foreach ($burgerIds as $id) {
               $insertOrder = $pdo->prepare(
                     "INSERT INTO OrderBurger(idOrderBurger)
                     VALUES (NULL)"
                );

                if($insertOrder->execute()) {
                     echo "success<br>";
                } else {
                       echo "fail<br>";
                       $errorData = $insertOrder->errorInfo();
                       echo $errorData[2] . "<br>";
                }
            }

            
            foreach ($burgers as $burger => $ingredients) {
                foreach ($ingredients as $id => $toppingObj) {
                    foreach ($toppingObj as $item => $id) {
                        echo "$item : $id<br>";
                       /* $insertOrderBurger = $pdo->prepare(
                              "INSERT INTO OrderBurger_has_MenuItem(OrderBurger_idOrderBurger, MenuItem_idMenuItem) 
                              VALUES (:idOrderBurger, :idMenuItem)"
                         );
                         $insertOrderBurger->bindParam(':idOrderBurger', $burger);
                         $insertOrderBurger->bindParam(':idMenuItem', $id);
                         
                         if ($insertOrderBurger->execute()) {
                              echo "success<br>";
                         } else {
                                echo "fail<br>";
                                $errorData = $insertOrderBurger->errorInfo();
                                echo $errorData[2] . "<br>";
                         }*/
                    }
                }
            } 

            #var_dump($order['order']['burgers'][0][1]);
        }

	$menu_loc = "./menu.json";
        $order_loc = "./order.json";
	$menu = getMenuItems($menu_loc);
	$pdo = getDBConnection();
        #buildItemInfo($pdo, $menu);
        $order = buildOrder($pdo, $order_loc);	
        
?>
