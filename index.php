<?php require_once('header.php') ?>

<section class="body">
    <div class="inner-body">
        <h1>Bienvenue dans ReduceLink</h1>
        <h4 class="info">Coller votre lien pour commencer</h4>
        <form action="includes/shorturl.inc.php" method="POST" class="form-url">
            <input type="url" name="input_url" placeholder="Entrez votre URL ici" pattern="https://.*" size="30"
                   required>
            <button type="submit" name="submit_url" value="shorten">Raccourcir</button>
        </form>
<!--        --><?php //if ($_GET["error"] == "none"): ?>
<!--            <p>--><?//= $_SESSION["short"] ?><!--</p>-->
<!--        --><?php //endif; ?>
    </div>
</section>

<?php require_once('footer.php'); ?>




