<?php
require(__DIR__ . "/header.php");
?>

<form method="POST">
<label for="address"><br>Delivery Address
    <input type="text" id="address" name="address"/>
</label>
<input type="submit" name="COrder" value="Pay & Complete Order"/>
</form>

<?php
if(isset($_POST["COrder"])) {
    if (isset($_POST["address"])) {


        $address = $_POST["address"];
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        $db = new PDO($connection_string, $dbuser, $dbpass);

        $stmt = getDB()->prepare("SELECT Max(order_id) as max from Orders");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $order_id = (int)$result["max"];
        $order_id++;

        $stmt = $db->prepare("SELECT * FROM Cart where user_id = :id and quantity > 0");
        $stmt->execute([":id" => $_SESSION["user"]["id"]]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $row):
            $product = get($row, "product_id");
            $quantity = get($row, "quantity");
            $subtotal = get($row, "subtotal");

            $stmt = getDB()->prepare("INSERT INTO Orders (order_id, product_id, user_id, quantity_purchased, address, subtotal where
order_id = :oid, product_id = :pid, user_id = :uid, quantity_purchased = :qp, address = :addr and subtotal = :stotal ");
            $stmt->execute([":oid"=>$order_id, ":pid"=>$product_id, ":uid"=>$_SESSION["user"]["id"], "qp"=>$quantity, ":addr"=>$address, ":stotal"=>$subtotal]);
        endforeach;

    }
}