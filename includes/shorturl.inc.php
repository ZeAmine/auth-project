<?php
session_start();
if (isset($_POST["submit_url"])) {
    $input_url = filter_input(INPUT_POST, "input_url");
    $short_url = substr(md5($input_url . mt_rand()), 0, 4);

    require_once('functions.inc.php');
    require_once('dburl.inc.php');

    $user = $_SESSION["user"];
    createUrl($pdo, $input_url, $short_url, $user);

} else {
    header("location: ../index.php?error=nourl");
    exit();
}
