<?php
require(__DIR__ . "/header.php");

$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);

$user_id = $_SESSION["user"]["id"];

$stmt = $db->prepare("SELECT * FROM Cart where user_id = :id");
$stmt->execute([":id" => $user_id]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<ul class="cart">
    <?php foreach($result as $row):?>
        <?php if(get($row, "quantity") > 0) {;?>
            <li>
                <?php

                $stmt = $db->prepare("SELECT * FROM Products where id = :id");
                $stmt->execute([":id" => get($row, "product_id")]);
                $newProduct = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>

                <?php echo get($newProduct, "product")?>
                $<?php echo get($row, "subtotal");?>
                Quantity: <?php echo get($row, "quantity");?>
                <?php echo get($row, "id");?>
                <a href="shop.php?thingId=<?php echo get($row, "id");?>">View product page</a><br>
            </li>
        <?php }?>
    <?php endforeach;?>
</ul>