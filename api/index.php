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
*	Hello
*/
$app->get('/hello/:last/:first/:MI', function($last, $first, $MI) {
	echo "Hello, $first $MI. $last!";
});

/**
*	Login
*
*	Owner: Luke
*/
$app->post('/login', function() {
	global $pdo;
	$args[":email"] = $_POST['email'];
	$args[":password"] = $_POST['password'];
	$statement = $pdo->prepare(
		"SEECT * FROM User
		WHERE email = :email AND password = :password;");
	if ($statement->execute($args)) {
		if ($row = $statement->fetch()) {
			$result["success"]=true;
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
*	Create Account
*
* 	Owner: Luke
*/
$app->post('/createAccount', function() {
	global $pdo;
	$args[':lName'] = $_POST['lName'];
	$args[':fName'] = $_POST['fName'];
	$args[':email'] = $_POST['email'];
	$args[':cardNum'] = $_POST['cardNum'];
	$args[':cardType'] = $_POST['cardType'];
	$args[':phoneNum'] = $_POST['phoneNum'];
	$args[':username'] = $_POST['username'];
	$args[':password'] = $_POST['password'];
	$statement = $pdo->prepare(
		"INSERT INTO user(lName, fName, email, cardNum, cardType, phoneNum, username, password) VALUES 
		(:lName, :fName, :email, :cardNum, :cardType, :phoneNum, :username, :password);");
	if ($statement->execute($args)) {
		$result["success"] = true;
	} else {
		$result["success"]=false;
		$result["error"]=$statement->errorInfo()[2];
	}
	echo json_encode($result);
});

/**
*	Place Order
*
*	Owner: Zach
*/
$app->post('/placeOrder', function() {

});

/**
*	Past Orders
*
*	Owner: Danny
*/
$app->post('/pastOrders', function() {

});

/**
*	Get Menu
*
*	Owner: Nicole
*/
$app->get('/getMenu', function() {

});

$app->run();

?>
