<?php

$ip = "localhost";
$port = 3306;
$username = "root";
$password = "";
$dbname = "auth-project";

$pdo = new PDO("mysql:host=localhost;dbname=auth-project", $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);




