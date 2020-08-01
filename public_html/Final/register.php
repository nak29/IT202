<?php require(__DIR__ . "/header.php");?>
<h4>Register</h4>
    <?php if (!isset($_SESSION["user"])) {?>
<form method="POST">
    <label for="email">Email
        <input type="email" id="email" name="email" autocomplete="off" />
    </label>
    <label for="p"><br>Password
        <input type="password" id="p" name="password" autocomplete="off"/>
    </label>
    <label for="cp"><br>Confirm Password
        <input type="password" id="cp" name="cpassword"/>
    </label>
    <label for="fname"><br>First Name
        <input type="text" id="fname" name="fname"/>
    </label>
    <label for="sname"><br>Last Name
        <input type="text" id="sname" name="sname"/>
    </label>
    <input type="submit" name="register" value="Register"/>
</form>

<?php}
else{
    ?><p class="error"><?php echo "You area already logged in!"?></p><?php;
}


//echo var_export($_GET, true);
//echo var_export($_POST, true);
//echo var_export($_REQUEST, true);
if(isset($_POST["register"])){
    if(isset($_POST["password"]) && isset($_POST["cpassword"]) && isset($_POST["email"])){
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
        $email = $_POST["email"];
        $fname = $_POST["fname"];
        $sname = $_POST["sname"];
        if($password == $cpassword){
            //echo "<div>Passwords Match</div>";
            $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
            try{
                $db = new PDO($connection_string, $dbuser, $dbpass);
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $db->prepare("INSERT INTO Users (email, password, first_name, last_name) VALUES(:email, :password, :fname, :sname)");
                $stmt->execute(array(
                    ":email" => $email,
                    ":password" => $hash,//Don't save the raw password $password
                    ":fname" => $fname,
                    ":sname" => $sname
                ));
                $e = $stmt->errorInfo();
                if($e[0] != "00000"){
                    echo var_export($e, true);
                }
                else{
                    echo "<div>Successfully registered! Welcome " . $fname . "!</div>";
                }
            }
            catch (Exception $e){
                echo $e->getMessage();
            }
        }
        else{
            echo "<div>Passwords don't match</div>";
        }
    }
}
?>