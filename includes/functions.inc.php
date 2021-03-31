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
    $stmt = $pdo->prepare("SELECT * FROM users WHERE userName = :userName OR userEmail = :userEmail");
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

        $stmm = $pdo->prepare("SELECT * FROM users WHERE userName = :userName");
        $stmm->execute([":userName" => $user]);
        $actualTable = $stmm->fetchAll(PDO::FETCH_ASSOC);

        $initState = "active";
        $nbUrl = 0;
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
        $newState = 'state' . substr($newLong, -1);
        if (end($actualArray) != null) {
            $newShort = 'urlShort' . $counter;
            $newLong = 'urlLong' . $counter;
            $newState = 'state' . $counter;
            $stmc = $pdo->prepare("ALTER TABLE users ADD $newState TEXT, ADD $newLong TEXT,  ADD $newShort TEXT");
            $stmc->execute();
        }

        var_dump($newState);
        $stmt = $pdo->prepare("UPDATE users SET " . $newState . " = :state ," . $newLong . " = :long_url, " . $newShort . " = :short_url, nbUrl = :nbUrl WHERE userName = :userName");
        var_dump($stmt);
        $stmt->execute([
            ":long_url" => $input_url,
            ":short_url" => $short_url,
            ":userName" => $user,
            ":nbUrl" => $nbUrl,
            ":state" => $initState,
        ]);

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

function createUrlUser($pdo, $url_user, $short_url_user, $user)
{
    if (!empty($url_user)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE userName = :userName");
        $stmt->execute([":userName" => $user,]);
        $actualTable = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $nbUrl = 0;
        $initState = "active";
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
        $newState = 'state' . substr($newLong, -1);
        if (end($actualArray) != null) {
            $newShort = 'urlShort' . $counter;
            $newLong = 'urlLong' . $counter;
            $newState = 'state' . $counter;
            $stmc = $pdo->prepare("ALTER TABLE users ADD $newState TEXT, ADD $newLong TEXT,  ADD $newShort TEXT");
            $stmc->execute();
        }

        $stmt = $pdo->prepare("UPDATE users SET " . $newState . " = :state ," . $newLong . " = :long_url, " . $newShort . " = :short_url, nbUrl = :nbUrl WHERE userName = :userName");
        $stmt->execute([
            ":long_url" => $url_user,
            ":short_url" => $short_url_user,
            ":userName" => $user,
            ":nbUrl" => $nbUrl,
            ":state" => $initState,
        ]);

        url($pdo, $user);
        $_SESSION["short"] = $short_url_user;
        $_SESSION["url"] = $url_user;

        header("location: ../profile.php");
        exit();
    } else {
        header("location: ../profile.php?error=emptyinput");
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

function url($pdo, $user)
{
    $stmm = $pdo->prepare("SELECT * FROM users WHERE userName = :userName");
    $stmm->execute([":userName" => $user]);
    $actualTable = $stmm->fetchAll(PDO::FETCH_ASSOC);

    $nbUrl = 0;

    foreach ($actualTable as $actualArray) {
        foreach ($actualArray as $key => $val) {
            if (strstr($key, 'url') && $val != null) {
                $nbUrl++;
            }
        }
    }
    $nbUrl = ($nbUrl / 2);
    $_SESSION["nbUrl"] = $nbUrl;
}

function click() {
    $stmm = $pdo->prepare("UPDATE users SET nbUrl = :nbUrl WHERE");
    $stmm->execute([]);
    $actualTable = $stmm->fetchAll(PDO::FETCH_ASSOC);
}

function displayUrl($pdo, $user)
{
    $stmm = $pdo->prepare("SELECT * FROM users WHERE userName = :userName");
    $stmm->execute([":userName" => $user]);
    $actualTable = $stmm->fetch(PDO::FETCH_ASSOC);

    for ($i = 1; $i <= $_SESSION['nbUrl']; $i++) { ?>
        <li class="item-url">
            <div>
                <p><?= $i ?></p>
                <div class="display-url">
                    <a class="long-lenght" href="<?= $actualTable["urlLong" . $i] ?>" target="_blank"
                       onclick=counterUp()>
                        <?= $actualTable["urlLong" . $i] ?>
                    </a>
                    <a class="shortner-lenght" href="<?= $actualTable["urlLong" . $i] ?>" target="_blank"
                       onclick=counterUp()>
                        <span>Voici votre URL raccourci :</span>
                        http://reducelink/v.php?key=<?= $actualTable["urlShort" . $i] ?>
                    </a>
                </div>
            </div>
            <div class="display-button">
                <h4>Click: <span class="nb-click">0</span></h4>
                <button class="urlBtn<?= $i ?> active" onclick=changeState()>active</button>
                <button><img src="img/bin2.svg"></button>
            </div>
        </li>

    <?php } ?>
    <script>
        function changeState() {
            let target = event.target
            let state = target.classList[1]
            if (state === 'active') {
                target.classList.remove('active');
                target.classList.add('inactive');
                target.innerText = "inactive"
            } else {
                target.classList.remove('inactive');
                target.classList.add('active');
                target.innerText = "active"
            }
        }

        function counterUp() {
            const counterNum = document.querySelector('.nb-click')
            counterNum.innerHTML++
        }
    </script>
<?php } ?>