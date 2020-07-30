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

        $user_id = $_SESSION["user"]["id"];
        $address = $_POST["address"];
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";

        $stmt = getDB()->prepare("SELECT Max(order_id) as max from Orders");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $order_id = (int)$result["max"];
        $order_id++;

        print_r($result);
        echo $order_id;


        $stmt2 = getDB()->prepare("SELECT * FROM Cart where user_id = :id and quantity > 0");
        $stmt2->execute([":id" => $user_id]);
        $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        ?><br><br><?php
        print_r($result2);

        echo 0;
        foreach($result2 as $row):
            echo 1;
            $product = get($row, "product_id");
            $quantity = get($row, "quantity");
            $subtotal = get($row, "subtotal");

            echo 2;

            $stmt3 = getDB()->prepare("INSERT INTO Orders (order_id, product_id, user_id, quantity_purchased, address, subtotal) VALUES
(:oid, :pid, :uid, :qp, :addr, :stotal)");
            $stmt3->execute([":oid"=>$order_id, ":pid"=>$product, ":uid"=>$user_id, "qp"=>$quantity, ":addr"=>$address, ":stotal"=>$subtotal]);
            echo 3;
            echo $order_id . $product . $user_id . $quantity . $address . $subtotal;
        endforeach;

    }
}