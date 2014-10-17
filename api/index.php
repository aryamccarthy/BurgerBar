<?php

require 'vendor/autoload.php';

$app = new \Slim\Slim();
try {
    $host = "localhost";
    $pdo = new PDO("mysql:host=$host;dbname=BurgerBar", "root", "root");
} catch (PDOException $e) {
    $response = "Failed to connect: ";
    $response .= $e->getMessage();
    die ($response);
}

/**
*   Hello
*/
$app->get('/hello/:last/:first/:MI', function($last, $first, $MI) {
    echo "Hello, $first $MI. $last!";
});

/**
*   Login
*
*   Owner: Luke
*/
$app->post('/login', function() {
    global $pdo;
    session_start();
    $args[":email"] = $_POST['email'];
    $args[":password"] = $_POST['password'];
    $statement = $pdo->prepare(
        "SELECT * FROM User
        WHERE email = :email AND password = :password;");
    if ($statement->execute($args)) {
        if ($row = $statement->fetch($fetch_style=$pdo::FETCH_ASSOC)) {
            $result["userInfo"]=$row;
            $result["success"]=true;
            $_SESSION['userInfo'] = $row;
            $_SESSION['isLoggedIn'] = TRUE;
        } else {
            $result["success"]=false;
        }
    } else {
        $result["success"]=false;
        $result["error"]=$statement->errorInfo();
    }
    echo json_encode($result);
});

/**
*   Logout
*
*   Owner: Luke
*/
$app->post('/logout', function() {
    session_start();
    $_SESSION['isLoggedIn']=FALSE;
    session_destroy();
});

/**
*   Create Account
*
*   Owner: Luke
*/
$app->post('/createAccount', function() {
    global $pdo;
    $args[':lName'] = $_POST['lName'];
    $args[':fName'] = $_POST['fName'];
    $args[':email'] = $_POST['email'];
    $args[':cardNum'] = $_POST['cardNum'];
    $args[':cardType'] = $_POST['cardType'];
    $args[':phoneNum'] = $_POST['phoneNum'];
    $args[':password'] = $_POST['password'];
    $statement = $pdo->prepare(
        "INSERT INTO user(lName, fName, email, cardNum, cardType, phoneNum, password) VALUES 
        (:lName, :fName, :email, :cardNum, :cardType, :phoneNum, :password);");
    if ($statement->execute($args)) {
        $result["success"] = true;
    } else {
        $result["success"]=false;
        $result["error"]=$statement->errorInfo();
    }
    echo json_encode($result);
});

/**
*   Get Menu Burgers
*
*   Owner: Luke
*/
$app->get('/getMenuBurgers', function() {
    global $pdo;
    $statement = $pdo->prepare(
        "SELECT idMenuBurger AS idBurger, MenuBurger.name AS burgerName, photoFilePath, idMenuItem as idItem, MenuItem.name AS itemName, price
        FROM MenuBurger_has_MenuItem
        NATURAL JOIN (MenuBurger, MenuItem)
        ORDER BY idBurger;");
    if ($statement->execute()) {
        $idBurger = null;
        $burgers = null;
        while($row = $statement->fetch()) {
            if ($idBurger != $row['idBurger']) {
                $idBurger = $row['idBurger'];
                $burgers[$idBurger]['photoFilePath'] = $row["photoFilePath"];
                $burgers[$idBurger]['name'] = $row["burgerName"];
                $burgers[$idBurger]['items'] = array();
            }
            $item['idItem'] = (int)$row['idItem'];
            $item['name'] = $row['itemName'];
            $item['price'] = (int) $row['price'];
            array_push($burgers[$idBurger]['items'], $item);
        }
        $result['menuBurgers']=$burgers;
    } else {
        $result['success']=false;
        $result['error']=$statement->errorInfo();
    }
    echo json_encode($result);
});

/**
*   Place Order
*
*   Owner: Zach
*/
$app->post('/placeOrder', function() {
    global $pdo;
    $json = $_POST['order'];
    $order = json_decode($json, true);
    $userEmail = $order['email'];
    $timeStamp = $order['order']['timeStamp'];
    $burgers = $order['order']['burgers'];
    $orderBurgerIds = array();
    $errorInfo = array();
    $success = False;
    $orderId = 0;

   /* $lName = 'Laugia';
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
    }*/

    $insertOrder = $pdo->prepare( #prepare to insert info into UserOrder table
        "INSERT INTO UserOrder(timestamp, email)
        VALUES(:timestamp, :email)"
    );
    $insertOrder->bindParam(':timestamp', $timeStamp);
    $insertOrder->bindParam(':email', $userEmail);

    if ($insertOrder->execute()) {
        $success = True;
    } else {
          $result = "failed to add desired order into database: ";
          $errorData = $insertOrder->errorInfo();
          $result .= $errorData[2];
          array_push($errorInfo, $result);
    } 

    foreach ($burgers as $burger) { #assign an ID to each burger in the order
        $insertOrderBurger = $pdo->prepare(
            "INSERT INTO OrderBurger(idOrderBurger)
            VALUES (NULL)"
        );

        if ($insertOrderBurger->execute()) {
           $success = True;
        } else {
              $result =  "failed to add burger into database: ";
              $errorData = $insertOrderBurger->errorInfo();
              $result .= $errorData[2];
              array_push($errorInfo, $result);
        }
    }

    $orderBurgers = $pdo->prepare("SELECT idOrderBurger FROM OrderBurger");
    if ($orderBurgers->execute()) { #access burger ids
        $success = True;
        while($row = $orderBurgers->fetch()) {
            array_push($orderBurgerIds, $row['idOrderBurger']); #store ids in array
        }
    } else {
          $result "failed to access burger ID for this order: ";
          $errorData = $orderBurgers->errorInfo();
	  $result .= $errorData[2];
          array_push($errorInfo, $result);
    }

    $getOrderId = $pdo->prepare( #get the ID of the current order
        "SELECT idUserOrder FROM UserOrder
        WHERE email = :email AND timestamp = :timestamp
    ");
    $getOrderId->bindParam(':email', $userEmail); 
    $getOrderId->bindParam(':timestamp', $timeStamp);

    if ($getOrderId->execute()) {
        $success = True;
        while($row = $getOrderId->fetch()) {
            $orderId = $row['idUserOrder'];
        }
    } else {
          $result = "failed to access order ID for this order: ";
          $errorData = $orderBurgers->errorInfo();
          $result .= $errorData[2];
          array_push($errorInfo, $result);
    }
    
    foreach ($burgers as $burger => $ingredients) {
        $insertHasOrderBurger = $pdo->prepare( #insert each burger in the order
            "INSERT INTO Order_has_OrderBurger(idUserOrder, idOrderBurger)
            VALUES(:idUserOrder, :idOrderBurger)"
        );
        $insertHasOrderBurger->bindParam(':idUserOrder', $orderId);
        $insertHasOrderBurger->bindParam('idOrderBurger', $orderBurgerIds[$burger]);                        

        if ($insertHasOrderBurger->execute()) {
            $success = True;
        } else {
              $result = "failed to added burgerID-orderID association: ";
              $errorData = $insertHasOrderBurger->errorInfo();
              $result .= $errorData[2];
              array_push($errorInfo, $result);
        }
 
        foreach ($ingredients as $id => $toppingObj) {
            foreach ($toppingObj as $item => $id) {
                $insertOrderBurger = $pdo->prepare( #insert each topping and the burger ID
                    "INSERT INTO OrderBurger_has_MenuItem(idOrderBurger, idMenuItem) 
                    VALUES(:idOrderBurger, :idMenuItem)"
                );
                $insertOrderBurger->bindParam(':idOrderBurger', $orderBurgerIds[$burger]);
                $insertOrderBurger->bindParam(':idMenuItem', $id);
                         
                if ($insertOrderBurger->execute()) {
                    $success = True;
                } else {
                      $result = "failed to add burger-topping association: ";
                      $errorData = $insertOrderBurger->errorInfo();
                      $result .= $errorData[2];
                      array_push($errorInfo, $result);
                }
            }
        }
    }

    if ($success) {
        $results['pass'] = True;
        $results['user'] = $userEmail;
    } else {
          $results['pass'] = False;
          $results['errorInfo'] = $errorInfo;
    }
  
    return $results;
});

/**
*   Past Orders
*
*   Owner: Danny
*/
$app->post('/pastOrders', function() {
	global $pdo;
    
    $args[":email"] = $_GET['email'];
    $args[":number"] = $_GET['number'];
    
    $statement = $pdo->prepare("SELECT timestamp, email FROM Order WHERE "
            . "email = :email LIMIT :number");
   
    
    if ($statement->execute($args)) {
        $result["success"] = true;
        
//store values in $result
    } 
    else {
        $result["success"]=false;
        $result["error"]=$statement->errorInfo();
    }
    echo json_encode($result);
});

/**
*   Get Menu
*
*   Owner: Nicole
*/
$app->get('/getMenu', function() {
    global $pdo;

    $statement = $pdo->prepare(
        "SELECT MenuComponent.name AS compName, MenuItem.idMenuComponent AS compID, 
            idMenuItem AS itemID, MenuItem.name AS itemName, price
        FROM MenuItem
        JOIN MenuComponent USING (idMenuComponent)
        ORDER BY idMenuComponent;");
    if ($statement->execute()) {
        $compGroup = NULL;
        $group;
        while($row = $statement->fetch($fetch_style=$pdo::FETCH_ASSOC)){
            if($compGroup != $row['compName']){
                $compGroup = $row['compName'];
                $group[$compGroup] = array();
            }
            $item['name'] = $row['itemName'];
            $item['price'] = $row['price'];
            array_push($group[$compGroup],$item);
        }

        $result['menu']=$group;
    } else {
        $result['success']=false;
        $result['error']=$statement->errorInfo();
    }
    echo json_encode($result);
});

$app->run();

?>
