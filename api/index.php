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
*/
$app->post('/login', function() {
	global $pdo;
	$args[":username"] = $_POST['username'];
	$args[":password"] = $_POST['password'];
	$statement = $pdo->prepare(
		"SELECT * FROM User
		WHERE username = :username AND password = :password;");
	if ($statement->execute($args)) {
		if ($row = $statement->fetch()) {
			$result["success"]=true;
		} else {
			$result["success"]=false;
		}
	} else {
		$result["success"]=false;
		$result["error"]=$statement->errorInfo()[2];
	}
	echo json_encode($result);
});

/**
*	Create Account
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
*/
$app->post('/placeOrder', function() {

});

/**
*	Past Ordesr
*/
$app->post('/pastOrders', function() {

});

/**
*	Is New Email
*/
$app->post('/isNewEmail', function() {

});

/**
*	Get All Burger Components
*/
$app->post('/getAllBurgerComponents', function() {

});

/**
*	Get All Burger Component By Type
*/
$app->post('/getAllBurgerComponentsByType', function() {

});

$app->run();

?>
