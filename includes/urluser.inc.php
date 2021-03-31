<?php
session_start();
if (isset($_POST["submit_url_user"])) {
    $url_user = filter_input(INPUT_POST, "url_user");
    $short_url_user = substr(md5($url_user . mt_rand()), 0, 4);

    require_once('functions.inc.php');
    require_once('dburl.inc.php');

    $user = $_SESSION["user"];
    createUrlUser($pdo, $url_user, $short_url_user, $user);

} else {
    header("location: ../profile.php?error=nourl");
    exit();
}