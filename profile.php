<?php require_once('header.php') ?>
<?php require_once('./includes/functions.inc.php');
displayUrl($pdo, $user);
?>
<?php require_once('./includes/displayurl.inc.php');?>


    <section class="profile">
        <div class="container">
            <h1>Votre Profile</h1>
            <div class="section-left">
                <div class="container-url">
                    <h4>Vos liens raccourci :</h4>
                    <ul class="list-url">
                        <?php if (isset($_SESSION["short"]) && isset($_SESSION["url"])):
                            displayUrl($pdo, $user);
                            ?>

                        <?php endif ?>
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
                        <p class="email">Nombre d'url(s) tranformées : <?=$_SESSION["nbUrl"]?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        function changeState() {
            const btn = document.querySelector('.state')
            const result = btn.classList.toggle("innative")

            if (result) {
                btn.innerText = "innactive"
                btn.style.color = "darkred"
                btn.style.border = "1px solid #912323"
                btn.style.background = "#ee9393"
            } else {
                btn.innerText = "active"
                btn.style.color = ""
                btn.style.border = ""
                btn.style.background = ""
            }
        }
    </script>

<?php require_once('footer.php'); ?>
