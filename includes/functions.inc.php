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
        url($pdo, $user);
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
                url($pdo, $user);
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
function createUrl($pdo, $input_url, $short_url, $user)
{
        if (!empty($input_url)) {
            $nbUrl = 0;
            $stmm = $pdo->prepare("SELECT * FROM users WHERE userName = :userName");
            $stmm->execute([
                ":userName" => $user,
            ]);
            $actualTable = $stmm->fetchAll(PDO::FETCH_ASSOC);

            $counter = 0;
            foreach ($actualTable as $actualArray) {
                foreach ($actualArray as $key => $val) {
                    if (strstr($key, 'url') != false) {
                        $counter++;
                    }
                }
                $counter = ($counter / 2) + 1;
            }
            $newLong = array_search(null, $actualArray);
            $newShort = str_replace('urlLong', 'urlShort', $newLong);
            if (end($actualArray) != null) {
                $newShort = 'urlShort' . $counter;
                $newLong = 'urlLong' . $counter;
                $stmc = $pdo->prepare("ALTER TABLE users ADD $newLong TEXT,  ADD $newShort TEXT");
                $stmc->execute();
            }
            $stmt = $pdo->prepare("UPDATE users SET " . $newLong . " = :long_url, " . $newShort . " = :short_url, nbUrl = :nbUrl WHERE userName = :userName");
            $stmt->execute([
                ":long_url" => $input_url,
                ":short_url" => $short_url,
                ":userName" => $user,
                ":nbUrl" => $nbUrl,
            ]);
            // $stmt->fetchAll(PDO::FETCH_ASSOC);

            url($pdo, $user);
            $_SESSION["short"] = $short_url;
            $_SESSION["url"] = $input_url;

            header("location: ../index.php");
            exit();
        } else {
            header("location: ../index.php?error=emptyinput");
            exit();
        }
    
}

function check($pdo, $input_url, $short_url, $user)
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

function url($pdo, $user){
    $nbUrl = 0;
    $stmm = $pdo->prepare("SELECT * FROM users WHERE userName = :userName");
    $stmm->execute([
        ":userName" => $user,
    ]);
    $actualTable = $stmm->fetchAll(PDO::FETCH_ASSOC);
    foreach($actualTable as $actualArray){
        foreach($actualArray as $key => $val){
            if(strstr($key, 'url') && $val != null){
                $nbUrl++;
            }
        }
    }
    $nbUrl = ($nbUrl/2);
    $_SESSION["nbUrl"] = $nbUrl;
}


function displayUrl($pdo, $user){
    $count = 0;
    $stmm = $pdo->prepare("SELECT * FROM users WHERE userName = :userName");
    $stmm->execute([":userName" => $user]);
    $actualTable = $stmm->fetch(PDO::FETCH_ASSOC);
    for ($i = 1; $i<= $_SESSION['nbUrl']; $i++){
    ?>
            <li class="item-url">
                <a href="#" target="_blank">http://reducelink/v.php?key=<?=$actualTable["urlShort".$i]?></a>
                <a href="#" target="_blank"><?=$actualTable["urlLong".$i]?></a>
                <button class="urlBtn<?=$i?> active" onclick=changeState()>active</button>
                <button ><img src="img/bin2.svg"></button>
            </li>
        <?php
    }
    ?>
    <script>
    function changeState() {
        let target = event.target
        let num = target.classList[0]
        let state = target.classList[1]
        if (state == 'active'){
            target.classList.remove('active');  
            target.classList.add('inactive');
            target.innerText = "inactive"
        } else{
            target.classList.remove('inactive');
            target.classList.add('active');
            target.innerText = "active"

        }

    }

</script>
<?php
}

?>