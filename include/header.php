<!doctype html>
<html>
	<head>
		<title><?php echo $pageTitle ?></title>
		<meta charset="UTF-8">		
		<meta name=viewport content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
		<meta name="description" content="Menu Items">
		<meta name="keywords" content="burgers,food,truck,order,menu">
		<?php
			if (is_array($javascript)) {
				foreach($javascript as $js) {
					echo '<script type="text/javascript" src="'.$js.'"></script>';
				}
			} else if (is_string($javascript)) {
				echo '<script type="text/javascript" src="'.$javascript.'"></script>';
			}
		?>
	</head>
	<body>
		<!--
		TODO: navbar
		-->
		<header></header>
		<nav></nav>
