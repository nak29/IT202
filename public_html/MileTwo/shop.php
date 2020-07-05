<?php
include("header.php");
?>
<?php foreach($results as $row):?>
    <li>
        <?php echo get($row, "id")?>
        <?php echo get($row, "product");?>
        <?php echo get($row, "quantity");?>
        <?php echo get($row, "price");?>
        <a href="delete.php?thingId=<?php echo get($row, "id");?>">Delete</a>
    </li>
<?php endforeach;?>

<?php
//echo var_export($_GET, true);
//echo var_export($_POST, true);
//echo var_export($_REQUEST, true);
if(isset($_POST["login"])){
    if(isset($_POST["password"]) && isset($_POST["email"])){
        $password = $_POST["password"];
        $email = $_POST["email"];
        require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try{
            $db = new PDO($connection_string, $dbuser, $dbpass);
            $stmt = $db->prepare("SELECT * FROM Users where email = :email LIMIT 1");
            $stmt->execute(array(
                ":email" => $email
            ));
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result){
                    $rpassword = $result["password"];
                    if(password_verify($password, $rpassword)){
                        echo "<div>Passwords matched! You are technically logged in!</div>";
                        $_SESSION["user"] = array(
                            "id"=>$result["id"],
                            "email"=>$result["email"],
                            "first_name"=>$result["first_name"],
                            "last_name"=>$result["last_name"]);
                    }
                    else{
                        echo "<div>Invalid password!</div>";
                    }
                }
                else{
                    echo "<div>Invalid user</div>";
                }
                //echo "<div>Successfully registered!</div>";
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
}