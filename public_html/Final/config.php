<?php
$cleardb_url      = parse_url(getenv("JAWSDB_URL"));
echo $cleardb_url;
$dbhost   = $cleardb_url["host"];
$dbuser = $cleardb_url["user"];
$dbpass = $cleardb_url["pass"];
$dbdatabase       = substr($cleardb_url["path"],1);
?>