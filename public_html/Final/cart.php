<?php
require(__DIR__ . "/header.php");

$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);

$user_id = $_SESSION["user"]["id"];

$stmt = $db->prepare("SELECT * FROM Cart where id = :id");
$stmt->execute([":id" => $user_id]);
$result = $stmt->fetchall(PDO::FETCH_ASSOC);

?>
<ul class="cart">
    <?php echo 0;?>
    <?php foreach($result as $row):
        echo 1;?>
        <?php if(get($row, "quantity") > 0) {
            echo 2;?>
            <li>
                <?php
                echo 3;
                $stmt = $db->prepare("SELECT * FROM Products where id = :id");
                $stmt->execute([":id" => get($row, "product_id")]);
                $newProduct = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>

                <?php echo get($newProduct, "product")?>
                <?php echo get($row, "subtotal");?>
                <?php echo get($row, "quantity");?>
                <?php echo get($row, "id");?>
                <a href="shop.php?thingId=<?php echo get($row, "id");?>">View</a>
            </li>
        <?php }?>
    <?php endforeach;?>
</ul>