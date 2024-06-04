<?php
session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

require_once '../../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all necessary fields are set
    if (isset($_POST['event_title']) && isset($_POST['event_description']) && isset($_FILES['event_image'])) {
        // Sanitize input data
        $event_title = filter_input(INPUT_POST, 'event_title', FILTER_SANITIZE_STRING);
        $event_description = filter_input(INPUT_POST, 'event_description', FILTER_SANITIZE_STRING);

        // Prepare and execute SQL query to insert event details
        $sql = "INSERT INTO events (title, description, image) VALUES (:event_title, :event_description, :event_image)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':event_title', $event_title, PDO::PARAM_STR);
        $stmt->bindParam(':event_description', $event_description, PDO::PARAM_STR);

        // Upload image file
        $targetDir = "recent_event_images/";
        $targetFilePath = $targetDir . basename($_FILES["event_image"]["name"]);
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES["event_image"]["tmp_name"], $targetFilePath)) {
            // Image uploaded successfully, proceed with database insertion
            $stmt->bindParam(':event_image', $targetFilePath, PDO::PARAM_STR);
            $stmt->execute();
            
            // Check if the query was successful
            if ($stmt->rowCount() > 0) {
                echo "Event details added successfully.";
            } else {
                echo "Failed to add event details.";
            }
        } else {
            echo "Error uploading image.";
        }
    } else {
        echo "Missing required fields.";
    }
}
?>
