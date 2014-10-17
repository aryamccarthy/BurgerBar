<!doctype html>
<html>
    <head>
        <title><?php echo $pageTitle ?></title>
        <meta charset="UTF-8">      
        <meta name=viewport content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
        <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
        <link rel="shortcut icon" href="./img/main_icon.png">
        <meta name="description" content="Menu Items">
        <meta name="keywords" content="burgers,food,truck,order,menu">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="./js/include.js"></script>
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
            <?php
                session_start();
                if ($_SESSION['isLoggedIn']==TRUE) {
                    include('logged-in.php');
                } else {
                    include('not-logged-in.php');
                }
            ?>    
        </header>
        <nav>
            <ul>
                <li><a href="account-form.php">Register</a></li>
                <li><a href="index.php">Order</a></li>
                <li><a href="about.php">About Us</a></li>
            </ul>
        </nav>
