<?php

function emptyInputSignup($user, $email, $password, $confirmPwd)
{
    $result;
    if (empty($user) || empty($email) || empty($password) || empty($confirmPwd)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidUid($user)
{
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $user)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email)
{
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function pwdMatch($password, $confirmPwd)
{
    $result;
    if ($password !== $confirmPwd) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function createUser($pdo, $user, $email, $password)
{
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
            INSERT INTO users (userName, userEmail, userPassword)
            VALUES (:userName, :userEmail, :userPassword)
        ");

        $hashPwd = password_hash($password, PASSWORD_DEFAULT);

        $stmt->execute([
            ":userName" => $user,
            ":userEmail" => $email,
            ":userPassword" => $hashPwd,
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
        $stmt = $pdo->prepare('INSERT INTO urls_data(long_url, short_url) VALUE (:long_url, :short_url)');
        $stmt->execute([
            ":long_url" => $input_url,
            ":short_url" => $short_url
        ]);
        $resultData = $stmt->fetchAll();

        $_SESSION["short"] = $resultData["short_url"];

        header("location: ../index.php?error=none");
        exit();

    } else {
        header("location: ../index.php?error=emptyinput");
        exit();
    }
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