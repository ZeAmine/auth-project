<?php

function emptyInputSignup($user, $email, $password, $confirmPwd)
{
    if (empty($user) || empty($email) || empty($password) || empty($confirmPwd)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidUid($user)
{
    if (!preg_match("/^[a-zA-Z0-9]*$/", $user)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function pwdMatch($password, $confirmPwd)
{
    if ($password !== $confirmPwd) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function createUser($pdo, $user, $email, $password, $nbUrl)
{
    $nbUrl = 0;
    $stmt = $pdo->prepare("
        SELECT * FROM users WHERE userName = :userName OR userEmail = :userEmail
    ");

    $stmt->execute([
        ":userName" => $user,
        ":userEmail" => $email,
    ]);
    $result = $stmt->rowCount();

    if ($result == 0) {
        $stmt = $pdo->prepare("
            INSERT INTO users (userName, userEmail, userPassword, nbUrl)
            VALUES (:userName, :userEmail, :userPassword, :nbUrl)
        ");

        $hashPwd = password_hash($password, PASSWORD_DEFAULT);

        $stmt->execute([
            ":userName" => $user,
            ":userEmail" => $email,
            ":userPassword" => $hashPwd,
            ":nbUrl" => $nbUrl,
        ]);

        header("location: ../signup.php?error=none");
        exit();

    } else {
        header("location: ../signup.php?error=usernametaken");
        exit();
    }
}


//____________________LOGIN______________________________

function loginUser($pdo, $user, $pass)
{
    if (!empty($user) || !empty($pass)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE userName = :userName");
        $stmt->execute([":userName" => $user]);
        $resultData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultData) {
            $checkPwd = password_verify($pass, $resultData["userPassword"]);

            if ($checkPwd == false) {
                header("location: ../signin.php?error=wrongpass");
                exit();
            } elseif ($checkPwd == true) {
                session_start();
                $_SESSION["user"] = $resultData["userName"];
                $_SESSION["email"] = $resultData["userEmail"];
                header("location: ../profile.php");
                exit();
            } else {
                header("location: ../signin.php?error=wrongpass");
                exit();
            }

        } else {
            header("location: ../signin.php?error=nouser");
            exit();
        }

    } else {
        header("location: ../signin.php?error=emptyinput");
        exit();
    }
}


//______________________URL_________________________________
function createUrl($pdo, $input_url, $short_url)
{

    if (!empty($input_url)) {
        $stmt = $pdo->prepare('
            INSERT INTO urls_data(long_url, short_url, checked)
            VALUE (:long_url, :short_url, :checked)
        ');
        $stmt->execute([
            ":long_url" => $input_url,
            ":short_url" => $short_url,
        ]);

        session_start();
        $_SESSION["short"] = $short_url;
        $_SESSION["url"] = $input_url;

    } else {
        header("location: ../index.php?error=emptyinput");
        exit();
    }
}

function check($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM urls_data ORDER BY id DESC");
    $stmt->execute();
    $resultData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultData["checked"]) {
        session_start();
        $_SESSION["checked"] = $resultData["checked"];
    }

    header("location: ../index.php");
    exit();
}


//function loginUser($pdo, $username, $password)
//{
//    if (!empty($username) || !empty($password)) {
//
//        $sql = "SELECT * FROM users WHERE userName = ?;";
//        $stmt = mysqli_stmt_init($pdo);
//        if (!mysqli_stmt_prepare($stmt, $sql)) {
//            header("location: ../signin . php ? error = stmtfailed");
//            exit();
//        }
//
//        mysqli_stmt_bind_param($stmt, "s", $user);
//        mysqli_stmt_execute($stmt);
//
//        if ($row = mysqli_fetch_assoc($resultData)) {
//            $checkPwd = password_verify($password, $row["userPassword"]);
//
//            if ($checkPwd == false) {
//                header("location: ../signin . php ? error = wrongpass");
//                exit();
//            } elseif ($checkPwd == true) {
//                session_start();
//                $_SESSION["user"] = $row["userName"];
//                header("location: ../index . php");
//                exit();
//            } else {
//                header("location: ../signin . php ? error = wrongpass");
//                exit();
//            }
//
//        } else {
//            header("location: ../signin . php ? error = nouser");
//            exit();
//        }
//
//    } else {
//        header("location: ../signin . php ? error = emptyinput");
//        exit();
//    }
//}

//function loginUser($pdo, $username, $password)
//{
//    $uidExists = UidExists($pdo, $username, $username);
//
//    if ($uidExists === false) {
//        header("location: ../signup . php ? error = wronglogin");
//        exit();
//    }
//
//    $pwdHashed = $uidExists["userPassword"];
//    $checkPwd = password_verify($password, $pwdHashed);
//
//    if ($checkPwd === false) {
//        header("location: ../signup . php ? error = wronglogin");
//        exit();
//    } else if ($checkPwd === true) {
//        session_start();
//        $_SESSION["user"] = $uidExists["userName"];
//        header("location: ../index . php");
//        exit();
//    }
//}


//function createUser($pdo, $user, $email, $password)
//{
//    $sql = "INSERT INTO users(userName, userEmail, userPassword) VALUES(?, ?, ?);";
//    $stmt = mysqli_stmt_init($pdo);
//    if (!mysqli_stmt_prepare($stmt, $sql)) {
//        header("location: ../signup . php ? error = stmtfailed");
//        exit();
//    }
//
//    $hashPwd = password_hash($password, PASSWORD_DEFAULT);
//
//    mysqli_stmt_bind_param($stmt, "sss", $user, $email, $hashPwd);
//    mysqli_stmt_execute($stmt);
//    mysqli_stmt_close($stmt);
//    header("location: ../signup . php ? error = none");
//    exit();
//}


//function UidExists($pdo, $user, $email)
//{
//    $sql = "SELECT * FROM users WHERE userName = ? or userEmail = ?;";
//    $stmt = mysqli_stmt_init($pdo);
//    if (!mysqli_stmt_prepare($stmt, $sql)) {
//        header("location: ../signup . php ? error = stmtfailed");
//        exit();
//    }
//
//    mysqli_stmt_bind_param($stmt, "ss", $user, $email);
//    mysqli_stmt_execute($stmt);
//
//    $resultData = mysqli_stmt_get_result($stmt);
//
//    if ($row = mysqli_fetch_assoc($resultData)) {
//        return $row;
//    } else {
//        $result = false;
//        return $result;
//    }
//
//    mysqli_stmt_close($stmt);
//}
