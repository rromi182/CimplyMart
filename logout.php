<?php

define('URL_BASE', 'http://localhost:50/CimplyMart');

$url_base = URL_BASE;

session_start();
session_destroy();
header("location:".$url_base."?alert=2");

?>