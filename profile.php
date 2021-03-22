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

<section class="body">
    <div class="inner-body">
        <h1>Votre compte</h1>
        <h4 class="info">Vous avez déjà reduit <?=$resultData['nbUrl']?> liens !</h4>
        <form action="includes/shorturl.inc.php" method="POST" class="form-url">
            <input type="url" name="input_url" placeholder="Entrez votre URL ici" pattern="https://.*" size="30"
                   required>
            <button type="submit" name="submit_url" value="shorten">Raccourcir</button>
        </form>
    </div>
</section>

<?php require_once('footer.php'); ?>
