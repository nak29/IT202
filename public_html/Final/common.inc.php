<?php
require(__DIR__ . "/config.php");


function get($arr, $key){

    if(isset($arr[$key])){
        return $arr[$key];
    }
    return "";
}
function getDB(){

    global $db;
    if(!isset($db)) {
        $cleardb_url      = parse_url(getenv("JAWSDB_URL"));
        $dbhost   = $cleardb_url["host"];
        $dbuser = $cleardb_url["user"];
        $dbpass = $cleardb_url["pass"];
        $dbdatabase       = substr($cleardb_url["path"],1);
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        $db = new PDO($connection_string, $dbuser, $dbpass);
    }
    return $db;
}