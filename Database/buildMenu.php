<?php

function getDBConnection() {
	try {
		$host = "localhost";
		$pdo = new PDO("mysql:$host;dbname=BurgerBar", "root", "root");
	} catch (PODExceptoin $e) {
		$response = "Failed to conect: ";
		$response = $e->getMessage();
		die($response);
	}
}

$pdo = getDBConnection();
$menuFilePath = "./menu.json";

$jsonFile = fopen($menuFilePath, 'r');

foreach ($menu as $component) {
	foreach ($menu->$component as $item) {
		echo $menu->$component[$item]->name
	}
}

?>