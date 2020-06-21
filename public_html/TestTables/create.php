<form method="POST">
    <label for="product">New Product
        <input type="text" id="product" name="product" />
    </label>
    <label for="p">Price
        <input type="number" id="p" name="price" />
    </label>
    <input type="submit" name="created" value="Submit New Product"/>
</form>

<?php
if(isset($_POST["created"])){
    $product = $_POST["product"];
    $price = $_POST["price"];
    if(!empty($product) && !empty($price)){
        require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try{
            $db = new PDO($connection_string, $dbuser, $dbpass);
            $stmt = $db->prepare("INSERT INTO Products (product, price) VALUES (:product, :price)");
            $result = $stmt->execute(array(
                ":product" => $product,
                ":price" => $price
            ));
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                echo var_export($result, true);
                if ($result){
                    echo "Successfully created new product: " . $product;
                }
                else{
                    echo "Error creating new product";
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
