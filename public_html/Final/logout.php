<?php
include(__DIR__ . "/header.php");
//session_start();
if (isset($_SESSION["user"])):?>
    <p>"Logging out..."</p>
<?php else:?>
    <p>"You aren't logged in but..."</p>
<?php endif;?>
<?php
session_unset();
session_destroy();
//echo "You have been logged out. ";
//echo var_export($_SESSION, true);
//get session cookie and delete/clear it for this session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    //clones then destroys since it makes it's lifetime
    //negative (in the past)
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
?>
<h4>Goodbye!</h4>
<title>logout page</title>
