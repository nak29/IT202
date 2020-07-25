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

    <form method="POST" action="shop.php?thingId=<?php get($result, "id")?>">
        <p class="pname"> <?php echo get($result, "product");?> </p>

        <p class="pdesc"> <?php echo get($result, "description");?> </p>

        <input type="submit" id="add" value="Add to cart"/>
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

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        if($thingId != -1) {
            if($_POST["add"]) {
                $user_id = $_SESSION["user"]["id"];
                $product_id = $_GET["thingId"];
                $price = get($result, "price");
                $stmt = getDB()->prepare("SELECT count(*) as num from Cart where user_id = :uid and product_id = :pid");
                $stmt->execute([":uid" => $user_id, ":pid" => $product_id]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $num = (int)$result["num"];
                echo "0";
                if ($num == 0) {
                    //insert
                    $stmt = getDB()->prepare("INSERT INTO Cart (product_id, user_id, quantity, subtotal) VALUES (:pid, :uid, :q, :st)");
                    $stmt->execute([":uid" => $user_id, ":pid" => $product_id, ":q" => 1, ":st" => $price]);
                    echo "1";
                } else {
                    //update
                    $stmt = getDB()->prepare("UPDATE Cart set quantity = quantity + :q, subtotal = quantity * :st where product_id = :pid AND user_id = :uid");
                    //pass q as amount to increment
                    //pass st as single item price
                    //DB should increment quantity by value and use the quantity * price to get subtotal
                    //TODO not sure if subtotal will be calced before or after the quantity update
                    $stmt->execute([":uid" => $user_id, ":pid" => $product_id, ":q" => 1, ":st" => $price]);
                    echo "2";
                }
            }
        }
    }

    else {

    }
}

?>