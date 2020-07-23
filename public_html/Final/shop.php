<?php
require(__DIR__ . "/header.php");
$query = file_get_contents(__DIR__ . "/queries/ASCEND_TABLE_PRODUCTS.sql");

$thingId = -1;
if(isset($_GET["thingId"])) {
    $thingId = $_GET["thingId"];
    $stmt = $db->prepare("SELECT * FROM Products where id = :id");
    $stmt->execute([":id" => $thingId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC); ?>
<p id="pname"> <?php echo get($thingId, "product")?> </p>

    <?php


    ?>
<hr>
<?php
}

$results = array();
try {
    $stmt = getDB()->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
catch (Exception $e) {
    echo $e->getMessage();
}
?>
<ul id="shop">

    <?php foreach($results as $row):?>
        <li>
            <?php echo get($row, "product")?>
            <?php echo get($row, "price");?>
            <?php echo get($row, "quantity");?>
            <?php echo get($row, "id");?>
            <a href="shop.php?thingId=<?php echo get($row, "id");?>">View</a>
        </li>
    <?php endforeach;?>
</ul>