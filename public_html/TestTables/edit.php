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
    echo "No product selected for change.";
}
?>

    <form method="POST">
        <label for="thing">New Product
            <input type="text" id="product" name="product" value="<?php echo get($result, "product");?>" />
        </label>
        <label for="p">Price
            <input type="number" id="q" name="price" value="<?php echo get($result, "price");?>" />
        </label>
        <input type="submit" name="updated" value="Update product"/>
    </form>

<?php
if(isset($_POST["updated"])){
    $product = $_POST["product"];
    $price = $_POST["price"];
    if(!empty($product) && !empty($price)){
        try{
            $stmt = $db->prepare("UPDATE Products set product = :product, price=:price where id=:id");
            $result = $stmt->execute(array(
                ":product" => $product,
                ":price" => $price,
                ":id" => $thingId
            ));
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                echo var_export($result, true);
                if ($result){
                    echo "Successfully updated thing: " . $product;
                }
                else{
                    echo "Error updating record";
                }
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "Product and price must not be empty.";
    }
}
?>