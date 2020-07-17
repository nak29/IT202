<?php
include("header.php");

?>
    <h4>Home</h4>

<?php echo "<div class=\"welcome\">Welcome " . $_SESSION["user"]["first_name"];"</div>";?>

<?php echo "Welcome " . $_SESSION["user"]["email"];?>
