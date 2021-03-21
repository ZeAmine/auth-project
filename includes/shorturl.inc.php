<?php

if (isset($_POST["submit_url"])) {
    $input_url = filter_input(INPUT_POST, "input_url");
    $short_url = substr(md5($input_url . mt_rand()), 0, 4);

    require_once('functions.inc.php');
    require_once('dburl.inc.php');

    createUrl($pdo, $input_url, $short_url);

} else {
    header("location: ../index.php?error=nourl");
    exit();
}
