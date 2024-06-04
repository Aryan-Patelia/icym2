<?php
session_start();

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    
    header('Location: login.php');
    exit();
}

if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 86400) {

    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}

$_SESSION['last_activity'] = time();
?>
