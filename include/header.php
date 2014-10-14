<!doctype html>
<html>
	<head>
		<title><?php echo $pageTitle ?></title>
		<meta charset="UTF-8">		
		<meta name=viewport content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
		<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
		<meta name="description" content="Menu Items">
		<meta name="keywords" content="burgers,food,truck,order,menu">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
		<header>
			<section id="title">
			<a href="index.php">
					<hgroup>
						<h1>Burger Bar</h1>
					</hgroup>
				</a>
			</section>
			<section id="login_section">
				<form id="login_form">
					<fieldset>
						<legend>Login</legend>
							<!--Pattern for noncompliant browsers from http://stackoverflow.com/questions/5601647/html5-email-input-pattern-attribute -->
							<input type="email" name="login_email" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Email" required/>
							<input type="password" name="login_password" pattern=".{8,24}" placeholder="Password" required/>
					</fieldset>
					<input type="submit" style="visibility: hidden; position: absolute;" />
				</form>
			</section>
			<!--Appears while logged in until logout.-->
			<section id="user_section">
				<h1>Hello, $$USER$$.</h1>
			</section>
		</header>
		<nav>
			<ul>
				<li><a href="account-form.html">Register</a></li>
				<li><a href="index.html">Order</a></li>
				<li><a href="about.html">About Us</a></li>
			</ul>
		</nav>
