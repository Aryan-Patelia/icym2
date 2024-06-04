<?php
session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

require_once '../../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['folder_name'])) {
    $folderName = $_POST['folder_name'];

    try {
        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO tbl_image_folder (folder_name) VALUES (:folderName)");

        // Bind the parameter
        $stmt->bindParam(':folderName', $folderName);

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error adding folder.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$conn = null;
?>
