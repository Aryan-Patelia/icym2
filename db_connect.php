<?php
require_once __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ , '.env');
$dotenv->load();

$servername = getenv('DB_HOST');
$username = getenv('DB_USER');
$password = getenv('DB_PASS');
$database = getenv('DB_NAME');

$conn = mysqli_connect($servername, $username, $password, $database);

echo $database;
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}else {
    echo "Connected successfully";
    echo "database : ".$database;
}

mysqli_set_charset($conn, "utf8");
?>
