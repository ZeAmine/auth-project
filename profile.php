<?php require_once('header.php') ?>
<?php
require_once('./includes/functions.inc.php');
require_once('./includes/dbh.inc.php');
$user = $_SESSION["user"];
$username = "root";
$password = "";
$pdo = new PDO("mysql:host=localhost;dbname=auth-project", $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
displayUrl($pdo, $user);
?>

<section class="profile">
    <div class="container">
        <h1>Votre Profile</h1>
        <div class="section-left">
            <div class="container-url">
                <h4>Vos liens raccourci :</h4>
                <ul class="list-url">
                    <?= displayUrl($pdo, $user) ?>
                </ul>
            </div>
        </div>
        <div class="section-right">
            <div class="block-user">
                <div class="picture">
                    <img src="./img/user.png" alt="picture profile">
                </div>
                <?php if (isset($_SESSION["email"]) && isset($_SESSION["user"])): ?>
                    <p class="user"><?= $_SESSION["user"] ?></p>
                    <p class="email"><?= $_SESSION["email"] ?></p>
                    <p class="email">Nombre d'url(s) tranformées : <?= $_SESSION["nbUrl"] ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php require_once('footer.php'); ?>
