<?php

$cleardb_url      = parse_url(getenv("JAWSDB_URL"));
$dbhost   = $cleardb_url["host"];
$dbuser = $cleardb_url["user"];
$dbpass = $cleardb_url["pass"];
$dbdatabase       = substr($cleardb_url["path"],1);

//echo var_export($_GET, true);
//echo var_export($_POST, true);
//echo var_export($_REQUEST, true);
if(isset($_POST["login"])){
    if(isset($_POST["password"]) && isset($_POST["email"])){
        $password = $_POST["password"];
        $email = $_POST["email"];

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
                        $_SESSION["user"] = array(
                            "id"=>$result["id"],
                            "email"=>$result["email"],
                            "first_name"=>$result["first_name"],
                            "last_name"=>$result["last_name"]);
                        require(__DIR__ . "/header.php");
                        echo "<div>Passwords matched! Welcome " . $_SESSION["user"]["first_name"] . "</div>";
                    }
                    else{
                        require(__DIR__ . "/header.php");
                        echo "<div>Invalid password!</div>";
                    }
                }
                else{
                    require(__DIR__ . "/header.php");
                    echo "<div>Invalid user</div>";
                }
            }
        }
        catch (Exception $e){
            require(__DIR__ . "/header.php");
            echo $e->getMessage();
        }
    }
}
include(__DIR__ . "/header.php");
?>
    <h4>Login</h4>
    <form method="POST">
        <label for="email">Email
            <input type="email" id="email" name="email" autocomplete="off" />
        </label>
        <label for="p">Password
            <input type="password" id="p" name="password" autocomplete="off"/>
        </label>
        <input type="submit" name="login" value="Login"/>
    </form>

<?php