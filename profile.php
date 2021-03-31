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

?>

    <section class="profile">
        <div class="container-profil">
            <div class="top-profil">
                <div class="left-profil">
                    <h1>Bienvenue </h1>
                    <p>Name : <?= $_SESSION["user"] ?></p>
                    <p>Mail : <?= $_SESSION["email"] ?></p>
                </div>
                <div class="right-profil">
                    <img src="img/profilpic.jpg">
                </div>
            </div>
            <div class="mid-profil">
                <div class="form-profil">
                    <form action="includes/shorturl.inc.php" method="POST" class="form-url">
                        <input type="url" name="input_url" placeholder="Coller votre URL ici pour le raccourcir" pattern="https://.*" size="30"
                            required>
                        <button type="submit" name="submit_url" value="shorten">Raccourcir</button>
                    </form>
                </div>    
                <div class="display-profil">
                    <?= displayUrl($pdo, $user) ?>
                </div> 

            </div>
            <div class="bottom-profil">
                <img src="img/bottompic.jpg">
                <div class="bottom-text-profil">
                <h1>Voici quelques statistiques : </h1>
                <p class="p-body">nombre d'URL transformé : <?= $_SESSION["nbUrl"] ?> </p>
                </div>
                
            </div>

        </div>
        
    </section>
<?php require_once('footer.php'); ?>
