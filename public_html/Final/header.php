<head>
    <title>Nick K's Site</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php

$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);

//HELPS A WHOLE LOT DONT GET RID OF
error_reporting(-1);
ini_set('display_errors', 1);
require(__DIR__ . "/common.inc.php");
session_start();
?>
<nav>
    <ul class="mymain">
        <li>
            <a href="home.php">Home</a>
        </li>
        <li>
            <a href="shop.php">Shop</a>
        </li>
        <li>
            <a href="cart.php">Cart</a>
        </li>
        <li>
            <a href="login.php">Login</a>
        </li>
        <li>
            <a href="register.php">Register</a>
        </li>
        <li>
            <a href="logout.php">Logout</a>
        </li>
    </ul>
</nav>
