<?php

if (isset($_POST["submit_url"])) {
    $user = filter_input(INPUT_POST, "input_url");

    require_once('functions.inc.php');
    require_once('dburl.inc.php');


    displayUrl($pdo, $user);

} else {
    header("location: ../index.php?error=nourl");
    exit();
}

