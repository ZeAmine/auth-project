<?php require_once('header.php') ?>

<section class="signin">
    <form action="includes/signin.inc.php" method="POST" class="form-signin">
        <h2>Se connecter</h2>
        <input type="text" name="user" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit" name="submit">Connection</button>
    </form>

    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo "<p>Veuillez compléter l'emsemble des informations.</p>";
        } else if ($_GET["error"] == "wrongpass") {
            echo "<p>Mot de passe incorrect. Veuillez réessayer.</p>";
        } else if ($_GET["error"] == "nouser") {
            echo "<p>Ce nom d'utilisateur n'existe pas.</p>";
        }
    }
    ?>
    
</section>

<?php require_once('footer.php') ?>
