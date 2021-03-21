<?php require_once('header.php') ?>

    <section class="signup">
        <form action="includes/signup.inc.php" method="POST" class="form-signup">
            <h2>S'inscrire</h2>
            <input type="text" name="user" placeholder="Nom d'utilisateur" required>
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="password" name="confirm-password" placeholder="Confirmer mot de passe" required>
            <button type="submit" name="submit">Crée</button>
        </form>


        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyinput") {
                echo "<p>Veuillez remplir l'emsemble des informations.</p>";
            } else if ($_GET["error"] == "invaliduid") {
                echo "<p>Identifiant : seules les lettres, les chiffres et les points sont autorisés.</p>";
            } else if ($_GET["error"] == "invalidemail") {
                echo "<p>Adresse email : seules les lettres et les chiffres sont autorisés.</p>";
            } else if ($_GET["error"] == "passwordsdontmatch") {
                echo "<p>Ces mots de passe ne correspondent pas. Veuillez réessayer.</p>";
            } else if ($_GET["error"] == "stmtfailed") {
                echo "<p>Probleme inattendu. Veuillez réessayer.</p>";
            } else if ($_GET["error"] == "usernametaken") {
                echo "<p>Ce nom d'utilisateur ou cette adresse email est déjà utilisé.</p>";
            } else if ($_GET["error"] == "none") {
                echo "<p class='none'>Votre compte a étè créé !</p>";
            }
        }
        ?>
    </section>

<?php require_once('footer.php') ?>