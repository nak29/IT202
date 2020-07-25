<?php
require(__DIR__ . "/header.php");
$query = file_get_contents(__DIR__ . "/queries/ASCEND_TABLE_PRODUCTS.sql");

$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);

$thingId = -1;
$result = array();
if(isset($_GET["thingId"])) {
    $thingId = $_GET["thingId"];
    $stmt = $db->prepare("SELECT * FROM Products where id = :id");
    $stmt->execute([":id" => $thingId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);?>

    <form action="/actions/add_to_cart.php">
        <p class="pname"> <?php echo get($result, "product");?> </p>

        <p class="pdesc"> <?php echo get($result, "description");?> </p>

        <input type="submit" value="Add to cart"/>
    </form>

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
<ul class="shop">

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