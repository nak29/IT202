<?php
require("config.php");
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$thingId = -1;
$result = array();
require("common.inc.php");
if(isset($_GET["thingId"])){
    $thingId = $_GET["thingId"];
    $stmt = $db->prepare("SELECT * FROM Products where id = :id");
    $stmt->execute([":id"=>$thingId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
else{
    echo "No product selected for deletion.";
}
?>

    <form method="POST">
        <label for="thing">New Product
            <input type="text" id="product" name="product" value="<?php echo get($result, "product");?>" />
        </label>
        <label for="<br>p">Price
            <input type="number" id="p" name="price" value="<?php echo get($result, "price");?>" />
        </label>
        <label for="<br>quantity">Quantity
            <input type="number" id="q" name="quantity" value="<?php echo get($result, "quantity");?>" />
        </label>
        <input type="submit" name="delete" value="Delete product"/>
    </form>

<?php
if(isset($_POST["delete"])){
    $delete = isset($_POST["delete"]);
    $product = $_POST["product"];
    if(!empty($product)) {
        try {
            if ($thingId > 0) {
                $stmt = $db->prepare("DELETE from Products where id=:id");
                $result = $stmt->execute(array(
                    ":id" => $thingId
                ));
            } else {
                echo "Product " . $product . " does not exist.";
            }
            $e = $stmt->errorInfo();
            if ($e[0] != "00000") {
                echo var_export($e, true);
            } else {
                echo var_export($result, true);
                if ($result) {
                    echo "Successfully deleted: " . $product;
                } else {
                    echo "Error deleting product";
                }
            }
        }
        catch
            (Exception $e){
                echo $e->getMessage();
            }
    }
    else{
        echo "Product must not be empty.";
    }
}
?>