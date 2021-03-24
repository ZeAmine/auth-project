<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReduceLink | Site Official</title>
    <link rel="stylesheet" href="styles/index.css">
</head>
<body>
<header>
    <nav>
        <a href="index.php" class="nav-brand">ReduceLink.</a>
        <ul class="nav-items">
            <?php if (isset($_SESSION["user"])): ?>
                <li><a href="./profile.php">Profil</a></li>
                <li><a href="./includes/logout.inc.php">Se deconnecter</a></li>
            <?php else: ?>
                <li><a href="signin.php">Se connecter</a></li>
                <li><a href="signup.php">S'inscrire</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
