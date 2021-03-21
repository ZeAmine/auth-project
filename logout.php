<?php require_once('header.php') ?>

<?php
session_start(); // On initialise la session...
session_destroy(); // ...pour mieux la détruire
header("Location: index.php"); // On envoie l'utilisateur vers l'index
exit(); // Et on arrête le script pour être sur que rien d'autre n'est exécuté
?>

<?php require_once('footer.php') ?>