<?php

require_once('dbh.inc.php');
require_once('functions.inc.php');

if (isset($_POST["submit"])) {
    $user = filter_input(INPUT_POST, "user");
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");
    $confirmPwd = filter_input(INPUT_POST, "confirm-password");

    if (emptyInputSignup($user, $email, $password, $confirmPwd) !== false) {
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    if (invalidUid($user) !== false) {
        header("location: ../signup.php?error=invaliduid");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../signup.php?error=invalidemail");
        exit();
    }
    if (pwdMatch($password, $confirmPwd) !== false) {
        header("location: ../signup.php?error=passwordsdontmath");
        exit();
    }

    createUser($pdo, $user, $email, $password);

} else {
    header("location: ../signup.php");
    exit();
}