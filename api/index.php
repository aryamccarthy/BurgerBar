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
        ORDER BY idBurger;")    ;
    if ($statement->execute()) {
        $idBurger = null;
        $burgers;
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
        "SELECT MenuComponent.name, MenuItem.idMenuComponent,
            idMenuItem, MenuItem.name, price
        FROM MenuItem
        JOIN MenuComponent
        USING (idMenuComponent)
        ORDER BY idMenuComponent;");
    $menu = array();
    while($temp = $statement->fetch_assoc()){
        $menu[] = $temp;
    }
    echo json_encode($menu);
});

$app->run();

?>
