<?php
require(__DIR__ . "/header.php");

if (isset($_SESSION["user"])) {

$user_id = $_SESSION["user"]["id"];

$stmt = getDB()->prepare("SELECT * FROM Orders where user_id = :id ORDER BY created;");
$stmt->execute([":id" => $user_id]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// giving value
$old_created = -1;
?>

<ul class="orders">

    <?php foreach($results as $row):?>
        <?php
        if (get($row, "created") != $old_created) {
            if ($old_created != -1){
                ?></ul><?php
            }
            ?>Order to be shipped to address: <b><?php echo get($row, "address");
            ?> </b> <br> <ul class="orders2"> <?php
        }
        ?><li><?php
        $stmt2 = getDB()->prepare("SELECT * FROM Products where id = :pid");
        $stmt2->execute([":pid" => get($row, "product_id")]);
        $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);

        echo get($result2, "product");?> x<?php
        echo get($row, "quantity_purchased");?> | $<?php
        echo get($row, "subtotal");
        $old_created = get($row, "created");?>
        </li>
    <?php endforeach;?>
</ul>

<?php}
else{
    ?><p class="error"><?php echo "Log in to view past orders!"?></p><?php;
}


