<?php

$server="localhost";
$username="root";
$password = "";
$database = "sysweb";
define('URL_BASE', 'http://localhost/CimplyMart');
$url_base = URL_BASE;

$mysqli = new mysqli($server, $username, $password, $database);

if($mysqli->connect_error){
    die('error'.$mysqli->connect_error);
}

?>