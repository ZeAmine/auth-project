<?php

if (isset($_POST["submit"])) {
    $user = filter_input(INPUT_POST, "user");
    $pass = filter_input(INPUT_POST, "password");

    require_once "dbh.inc.php";
    require_once "functions.inc.php";

//    if (emptyInputSignin($username, $password) !== false) {
//        header("location: ../signin.php?error=emptyinput");
//        exit();
//    }

    loginUser($pdo, $user, $pass);

} else {
    header("location: ../signin.php");
    exit();
}

