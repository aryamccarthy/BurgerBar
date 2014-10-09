<?php

require 'vendor/autoload.php';

$app = new \Slim\Slim();

// Hello World function
$app->get('/hello/:last/:first/:MI', 'hello');


$app->run();

function hello($last, $first, $MI) {
	echo "Hello, $first $MI. $last!";
}


?>