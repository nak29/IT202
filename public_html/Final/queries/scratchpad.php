<?php/*
user (id)
products (id, price, quantity)
cart(product_id, user_id, quantity, subtotal)
order(id, order_id, user_id, product_id, subtotal)
*/
$user_id = $_SESSION["user"]["id"];
$product_id = $_GET["product_id"];//mysite.com/add_cart.php?product_id=5
//fetch product info from table
$stmt = getDB()->prepare("SELECT * FROM Products where id = :id");
$stmt->execute([":id"]=>$product_id);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
$price = $product["price"];

//insert or update into cart
$stmt = getDB()->prepare("SELECT count(*) as num from Cart where user_id = :uid and product_id = :pid");
$stmt->execute([":uid"=>$user_id, ":pid"=>$product_id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$num = (int)$result["num"];
if($num == 0){
	//insert
	$stmt = getDB()->prepare("INSERT INTO Cart (product_id, user_id, quantity, subtotal) VALUES (:pid, :uid, :q, :st)");
	$stmt->execute([":uid"=>$user_id, ":pid"=>$product_id, ":q"=>1, ":st"=>$price]);
}
else{
	//update
	$stmt = getDB()->prepare("UPDATE Cart set quantity = quantity + :q, subtotal = quantity * :st where product_id = :pid AND user_id = :uid");
	//pass q as amount to increment
	//pass st as single item price
	//DB should increment quantity by value and use the quantity * price to get subtotal
	//TODO not sure if subtotal will be calced before or after the quantity update
	$stmt->execute([":uid"=>$user_id, ":pid"=>$product_id, ":q"=>1, ":st"=>$price]);
}

/////separate section
//give us total for cart for particular user
$stmt = getDB()->prepare("SELECT sum(subtotal) as total from Cart where user_id = :uid and quantity >= 1");
$stmt->execute([":uid"=>$user_id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);


//purchase cart
$stmt = getDB()->prepare("SELECT Max(order_id) as max from Orders");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$max = (int)$result["max"];
$max++;

$stmt = getDB()->prepare("INSERT INTO Orders (order_id, user_id, product_id, subtotal) 
						SELECT :max, user_id, product_id, subtotal from Cart where user_id = :uid and Cart.quantity >= 1");
$stmt->execute([":max"=>$max, ":uid"=>$user_id]);

//TODO delete cart if it was successful
///clear cart
$stmt = getDB()->prepare("DELETE FROM Cart where user_id = :uid");
$stmt->execute([":uid"=>$user_id]);


//display cart (obviously not at this point in the codE)
$stmt = getDB()->prepare("SELECT p.product as product_name, p.quantity as inventory, c.quantity as wanted, p.price as unit_price, c.subtotal FROM Products p join Cart c on c.product_id = p.id where c.user_id = :uid");
$stmt->execute([":uid"=>$user_id]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
//if ajax
return json_encode($data);//<- turns array into json

//if php templating
<?php foreach($data as $row):?>
	<p><?php echo $row["product_name"];?></p>
<?php endforeach;?>

"DELETE FROM Cart where user_id = :uid AND product_id = :pid"
"UPDATE CART quantity = quantity - :increment where user_id = :uid and product_id = :pid"





<?php
//single product view
$product_id = $_GET["product"];//website.com/view.php?product=1

$stmt = getDB()->prepare("SELECT * From Products where id = :id and quantity > 0");
$stmt->execute([":id"=>$product]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div>
<p>Name: <?php echo $result["product"];?></p>
<p>Price: <?php echo $result["price"];?></p>
	<button>Add to cart</button>

</div>

/////
//listing products view
"SELECT * FROM Products";
<?php foreach($results as $prod):?>
	<a href="view.php?product=<?php echo $prod["id"];?>">View More Details</a>
	<?php if((int)$prod["quantity"] <= 0):?>
		<p>Sorry out of stock<p>
	<?php else:?>
		<p>In stock!</p>
	<?php endif;?>
<?php endforeach;?>

