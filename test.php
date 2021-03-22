<?php
require_once("./includes/dbh.inc.php");

if (isset($_POST["submit"])) {
    $user = filter_input(INPUT_POST, "user");
    $pass = filter_input(INPUT_POST, "password");

    $stmt = $pdo->prepare("SELECT * FROM users WHERE userName = :userName");
    $stmt->execute([":userName" => $user]);
    $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultData) {
        $checkPwd = password_verify($pass, $resultData[0]["userPassword"]);

        if ($checkPwd == false) {
            header("location: ../signin.php?error=wrongpass");
            exit();
        } elseif ($checkPwd == true) {
            session_start();
            $_SESSION["user"] = $resultData["userName"];
            header("location: ../index.php");
            exit();
        } else {
            header("location: ../signin.php?error=wrongpass");
            exit();
        }

    } else {
        header("location: ../signin.php?error=nouser");
        exit();
    }
}

?>


<?php require_once("header.php") ?>

    <section>
        <?php
        if (isset($_SESSION["user"])) {
            echo "<h2>Tu t'es connecté !</h2>";
        } else {
            echo "<h2>Se connecter</h2>";
        }
        ?>
        <input type="text" name="user1" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password1" placeholder="Mot de passe" required>
        <button type="submit" name="submit">Connection</button>
    </section>

<?php require_once("footer.php") ?>