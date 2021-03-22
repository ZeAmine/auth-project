<?php require_once('header.php') ?>

<section class="body">
    <div class="inner-body">
        <?php if (isset($_SESSION["user"])): ?>
            <h1>Bienvenue <?= $_SESSION["user"] ?>, ravi de vous revoir</h1>
        <?php else: ?>
            <h1>Bienvenue dans ReduceLink</h1>
        <?php endif; ?>
        <h4 class="info">Coller votre lien pour commencer</h4>
        <form action="includes/shorturl.inc.php" method="POST" class="form-url">
            <input type="url" name="input_url" placeholder="Entrez votre URL ici" pattern="https://.*" size="30"
                   required>
            <button type="submit" name="submit_url" value="shorten">Raccourcir</button>
        </form>
    </div>
    <?php if (isset($_SESSION["short"]) && isset($_SESSION["url"])): ?>
        <div class="container-url">
            <a href="<?= $_SESSION["url"] ?>" target="_blank">http://localhost/v.php?key=<?= $_SESSION["short"] ?></a>
        </div>
    <?php endif; ?>
</section>

<?php require_once('footer.php'); ?>
