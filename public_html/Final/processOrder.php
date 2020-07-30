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
        echo $address;
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";

        $stmt = getDB()->prepare("SELECT Max(id) as max from Orders");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $order_id = (int)$result["order_id"];
        $order_id++;

        echo $order_id;

        $stmt2 = $db->prepare("SELECT * FROM Cart where user_id = :id and quantity > 0");
        $stmt2->execute([":id" => $_SESSION["user"]["id"]]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $row):
            $product = get($row, "product_id");
            $quantity = get($row, "quantity");
            $subtotal = get($row, "subtotal");

            $stmt3 = getDB()->prepare("INSERT INTO Orders (order_id, product_id, user_id, quantity_purchased, address, subtotal) VALUES
(:oid, :pid, :uid, :qp, :addr, :stotal)");
            $stmt3->execute([":oid"=>$order_id, ":pid"=>$product, ":uid"=>$_SESSION["user"]["id"], "qp"=>$quantity, ":addr"=>$address, ":stotal"=>$subtotal]);
            echo $stmt3;
            echo $order_id . $product . $_SESSION["user"]["id"] . $quantity . $address . $subtotal;
        endforeach;

    }
}