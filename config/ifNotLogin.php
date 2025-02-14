<?php

if(!isset($_COOKIE['login']) || !in_array($_COOKIE['role'], ['ADMIN', 'STAFF']) || !$_COOKIE['login']) {
    header("Location: " . $baseurl . "admin/index.php");
    exit();
}

?>