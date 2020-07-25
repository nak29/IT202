<?php
if($_POST){
    $user_id = $_SESSION["user"]["id"];
    $product_id = $_GET["product_id"];
    $stmt = getDB()->prepare("SELECT count(*) as num from Cart where user_id = :uid and product_id = :pid");
    $stmt->execute([":uid"=>$user_id, ":pid"=>$product_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $num = (int)$result["num"];
    echo "0";
    if($num == 0){
        //insert
        $stmt = getDB()->prepare("INSERT INTO Cart (product_id, user_id, quantity, subtotal) VALUES (:pid, :uid, :q, :st)");
        $stmt->execute([":uid"=>$user_id, ":pid"=>$product_id, ":q"=>1, ":st"=>$price]);
        echo "1";
    }
    else {
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