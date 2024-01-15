<?php
    session_start();

    $_SESSION = array();

    session_destroy();

    header("location: http://localhost/zadaca/php3/index.php");
    exit;
?>