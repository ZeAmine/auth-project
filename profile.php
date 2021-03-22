<?php require_once('header.php');
require_once('./includes/dbh.inc.php');

$stmt = $pdo->prepare("
    SELECT * FROM users WHERE userName = :userName"
);

$stmt->execute([
    ":userName" => $_SESSION["user"],
]);
$resultData = $stmt->fetch(PDO::FETCH_ASSOC);

?>

    <section class="profile">
        <div class="container">
            <h1>Votre Profile</h1>
            <div class="section-left">
                <form action="includes/shorturl.inc.php" method="POST" class="form-url">
                    <input type="url" name="input_url" placeholder="Entrez votre URL ici" pattern="https://.*"
                           size="30">
                    <button type="submit" name="submit_url" value="shorten">Raccourcir</button>
                </form>
            </div>
            <div class="section-right">
                <div class="block-user">
                    <div class="picture">
                        <img src="./img/user.png" alt="picture profile">
                    </div>
                    <?php if (isset($_SESSION["email"]) && isset($_SESSION["user"])): ?>
                        <p class="user"><?= $_SESSION["user"] ?></p>
                        <p class="email"><?= $_SESSION["email"] ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

<?php require_once('footer.php'); ?>
