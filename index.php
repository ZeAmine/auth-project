<?php require_once('header.php') ?>

<section class="body">
    <div class="inner-body">
        <div class="top-body">
            <div class="left-body">
                <?php if (isset($_SESSION["user"])): ?>
                    <h1>Bienvenue <?= $_SESSION["user"] ?>, ravi de vous revoir</h1>
                <?php else: ?>
                    <h1>URL Shortener</h1>
                    <p class="p-body">Stock and share your favorite Url !</p>
                    <a href="signin.php"><button class="btnTitle" type="submit" name="submit_url" value="shorten">S'inscrire</button></a>
                <?php endif; ?>
            </div>
            <div class="right-body">
                <img src="img/bonhomme">
            </div>
        </div>
        <div class="mid-body">
            <form action="includes/shorturl.inc.php" method="POST" class="form-url">
                <input type="url" name="input_url" placeholder="Coller votre URL ici pour le raccourcir" pattern="https://.*" size="30"
                    required>
                <button class="btnCheck" type="submit" name="submit_url" value="shorten">Raccourcir</button>
            </form>
            <p class="p-body">En utilisant notre service, vous acceptez <span class="purple-text">les conditions d’utilisation</span> et <span class="purple-text">la politique de confientialité.</span></p>
        </div>
        <div class="bottom-body">
            <img src="img/lbt">
            <div class="bottom-text">
                <h1>One short link, infinite possibilities.</h1>
                <p class="p-body">En utilisant notre service, vous acceptez de facilité votre quotidient grace a une facilité et une rapidité d’utilisation sans pareil !</p>
            </div>
        </div>
    </div>
    <?php if (isset($_SESSION["short"]) && isset($_SESSION["url"])): ?>
        <div class="container-url">
            <a href="<?= $_SESSION["url"] ?>" target="_blank">http://localhost/v.php?key=<?= $_SESSION["short"] ?></a>
        </div>
    <?php endif; ?>
</section>

<?php require_once('footer.php'); ?>
