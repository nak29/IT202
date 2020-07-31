<?php
require(__DIR__ . "/header.php");

$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);

//Checks if user is logged in, most of code is in a non-indented if-else
if (isset($_SESSION["user"])) {


$user_id = $_SESSION["user"]["id"];

$stmt = $db->prepare("SELECT * FROM Cart where user_id = :id");
$stmt->execute([":id" => $user_id]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["empty"])) {
        if (isset($_SESSION["user"])) {
            if ($_POST["empty"]) {
                foreach ($result as $rowEmpty):
                    $stmt = getDB()->prepare("UPDATE Cart set quantity = 0 where user_id = :id");
                    $stmt->execute([":id" => $user_id]);
                endforeach;

                $stmt = $db->prepare("SELECT * FROM Cart where user_id = :id");
                $stmt->execute([":id" => $user_id]);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }
}

?>
<ul class="cart">
    <?php foreach($result as $row):?>
        <?php if(get($row, "quantity") > 0) {;?>
            <li>
                <?php

                $stmt = $db->prepare("SELECT * FROM Products where id = :id");
                $stmt->execute([":id" => get($row, "product_id")]);
                $newProduct = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>

                <?php echo get($newProduct, "product")?>
                Quantity: <?php echo get($row, "quantity");?>
                $<?php echo get($row, "subtotal");?>
                <a href="shop.php?thingId=<?php echo get($row, "product_id");?>">View product page</a><br>
            </li>
        <?php }?>
    <?php endforeach;?>
</ul>
<br><?php
    $stmt = getDB()->prepare("SELECT sum(subtotal) as total from Cart where user_id = :uid and quantity >= 1");
    $stmt->execute([":uid"=>$user_id]);
    $cartTotal = $stmt->fetch(PDO::FETCH_ASSOC);?>
    <p class="welcome">Your total is <b>$<?php echo $cartTotal["total"]?></b></p>
    <br>
<form method="POST" action="processOrder.php">
    <input type="submit" name="process" value="Order items"/>
</form>
    <p>      </p>
<form method="POST" action="cart.php">
    <input type="submit" name="empty" value="EMPTY the cart"/>
</form>
<?php }

//if user is not logged in
else{
    ?><p class="error"><?php echo "Log in to view cart!"?></p><?php;
}