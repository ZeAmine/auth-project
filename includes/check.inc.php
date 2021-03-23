<?php

if (isset($_POST["submit_url"])) {
    $id = filter_input(INPUT_POST, "id");

    require_once('functions.inc.php');
    require_once('dburl.inc.php');

    check($pdo, $id);

} else {
    header("location: ../index.php?error=nourl");
    exit();
}
