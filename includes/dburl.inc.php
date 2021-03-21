<?php

$ip = "localhost";
$port = 3306;
$username = "root";
$password = "";
$dbname = "url-projet";

$pdo = new PDO("mysql:host=localhost;dbname=url-projet", $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

