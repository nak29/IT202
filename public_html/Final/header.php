<head>
    <title>Nick K's Site</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php

//HELPS A WHOLE LOT DONT GET RID OF
//error_reporting(-1);
//ini_set('display_errors', 1);
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
        <?php if (!isset($_SESSION["user"])) {?>
        <li>
            <a href="login.php">Login</a>
        </li>
        <li>
            <a href="register.php">Register</a>
        </li>
        <?php } ?>
        <?php if (isset($_SESSION["user"])) {?>
        <li>
            <a href="cart.php">Cart</a>
        </li>
        <li>
            <a href="orders.php">Old Orders</a>
        </li>
        <li>
            <a href="logout.php">Logout</a>
        </li>
        <?php } ?>
    </ul>
</nav>
