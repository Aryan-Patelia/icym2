<?php

session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

require_once __DIR__ . '/../../db_connect.php';

if (isset($_GET['folder'])) {
    $folderID = $_GET['folder'];

    try {
        $stmt = $conn->prepare("DELETE FROM tbl_image_folder WHERE tbl_image_folder_id = :folderID");
        $stmt->bindParam(':folderID', $folderID, PDO::PARAM_INT);
        $stmt->execute();

        $stmtImages = $conn->prepare("DELETE FROM tbl_image WHERE tbl_image_folder_id = :folderID");
        $stmtImages->bindParam(':folderID', $folderID, PDO::PARAM_INT);
        $stmtImages->execute();

        echo"
        <script>
            alert('Folder Deleted Successfully');
            window.location.href = 'http://localhost/image-gallery-app/';
        </script>
        ";
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
