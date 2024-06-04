<?php
session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

require_once __DIR__ . '/../../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["folder_name"])) {
        $folderID = $_POST['tbl_image_folder_id'];
        $folderName = $_POST["folder_name"];

        try {
            $stmt = $conn->prepare("UPDATE tbl_image_folder SET folder_name = :folder_name WHERE tbl_image_folder_id = :tbl_image_folder_id");
            $stmt->bindParam(":tbl_image_folder_id", $folderID);
            $stmt->bindParam(":folder_name", $folderName);

            $stmt->execute();

            echo"
            <script>
                alert('Folder Updated Successfully');
                window.location.href = 'http://localhost/image-gallery-app/';
            </script>
            ";
            exit();
        } catch (PDOException $e) {
            echo "Error: ". $e->getMessage();
        }
    
    }
}
?>