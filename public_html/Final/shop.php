<?php
error_reporting(-1);
ini_set('display_errors', 1);
include("header.php");
$query = file_get_contents(__DIR__ . "/queries/ASCEND_TABLE_PRODUCTS.sql");

$results = array();
try {
    require(__DIR__ . "/common.inc.php");
    $stmt = getDB()->prepare($query);
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
            <a href="delete.php?thingId=<?php echo get($row, "id");?>">Delete</a>
        </li>
    <?php endforeach;?>
</ul>