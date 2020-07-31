<?php
require(__DIR__ . "/header.php");

$user_id = $_SESSION["user"]["id"];

$stmt = getDB()->prepare("SELECT * FROM Orders where user_id = :id ORDER BY created;");
$stmt->execute([":id" => $user_id]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// giving value
$old_created = -1;
?>

<ul class="shop">

    <?php foreach($results as $row):?>
        <?php
        if (get($row, "created") != $old_created) {
            ?></li><li><?php
            ?>Order to be shipped to address: <?php echo get($row, "address");
        }
        ?><br><?php
        $stmt2 = getDB()->prepare("SELECT * FROM Products where id = :product;");
        $stmt2->execute([":product" => get($row, "product_id")]);
        $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print_r($result2);
        echo get($result2, "product");?>
        <?php echo get($row, "quantity_purchased");
        $old_created = get($row, "created");?>
    <?php endforeach;?>
</ul>




