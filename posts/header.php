<?php
require_once __DIR__ . '/../db_connect.php';
require_once 'functions.php'; // Assuming functions.php contains the definition of the posts class

// Pass the database connection to the constructor of the posts class
$posts = new posts($conn);
$pdo = $conn;
?>
