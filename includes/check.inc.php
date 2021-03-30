<?php

if (isset($_POST["submit_url"])) {
    $url = filter_input(INPUT_POST, "url");

    require_once('functions.inc.php');
    require_once('dburl.inc.php');

    check($pdo, $url);

} else {
    header("location: ../index.php?error=nourl");
    exit();
}
