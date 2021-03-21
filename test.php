<?php

require_once("./includes/dbh.inc.php");

$stmt = $pdo->prepare("SELECT * FROM users WHERE userName = :userName");
$stmt->execute([":userName" => `'` . $username . `'`]);
$resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST["submit"])) {
    $username = filter_input(INPUT_POST, "user");
    $password = filter_input(INPUT_POST, "password");

    $_SESSION["user"] = $username;
}


var_dump($username);
var_dump($password);

?>

<?php require_once("header.php") ?>
    <section>
        <h2>Se connecter</h2>
        <input type="text" name="user" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit" name="submit">Connection</button>
    </section>
<?php require_once("footer.php") ?>