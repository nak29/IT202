<head>
    <title>Nick K's Site</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php
//HELPS A WHOLE FUCcKIGN LOT DONT GET RID OF
error_reporting(-1);
ini_set('display_errors', 1);
include("common.inc.php");
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