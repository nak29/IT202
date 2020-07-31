<?php
require(__DIR__ . "/header.php");

$user_id = $_SESSION["user"]["id"];

$stmt = getDB()->prepare("SELECT * FROM Orders where user_id = :id ORDER BY created;");
$stmt->execute([":id" => $user_id]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<ul class="">

    <?php foreach($results as $row):?>
        <li>
            <?php echo get($row, "product_id")?>
            <?php echo get($row, "quantity_purchased");?>
            <?php echo get($row, "address");?>
        </li>
    <?php endforeach;?>
</ul>



