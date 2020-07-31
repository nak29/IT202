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
        <li>
            <?php
            if (get($row, "created") != $old_created) {
                ?><br><?php
                echo get($row, "address");
            }

            $stmt2 = getDB()->prepare("SELECT * FROM Products where id = :product_id;");
            $stmt2->execute([":product" => get($row, "product_id")]);
            $result2 = $stmt->fetch(PDO::FETCH_ASSOC);

            echo get($result2, "product")?>
            <?php echo get($row, "quantity_purchased");
            $old_created = get($row, "created");?>
        </li>
    <?php endforeach;?>
</ul>



<?php echo get($row, "address");?>


