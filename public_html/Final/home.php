<?php
include(__DIR__ . "/header.php");

?>
<h4>Home</h4>
<?php if (isset($_SESSION["user"])):?>
    <p class="welcome"><?php echo "Welcome " . $_SESSION["user"]["first_name"] . " " . $_SESSION["user"]["last_name"] ."!";?></p>
<?php else:?>
    <p class="welcome"><?php echo "Welcome new user!";?></p>
<?php endif;?>