<?php
session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

require_once "../../db_connect.php";

// Sanitize and validate inputs
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
$start = filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING);
$end = filter_input(INPUT_POST, 'end', FILTER_SANITIZE_STRING);

if ($id === false || $title === false || $start === false || $end === false) {
    die("Invalid input.");
}

try {
    // Prepare the SQL query using placeholders
    $sqlUpdate = "UPDATE tbl_events SET title = :title, start = :start, end = :end WHERE id = :id";
    $stmt = $conn->prepare($sqlUpdate);

    // Bind the parameters to the query
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':start', $start);
    $stmt->bindParam(':end', $end);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the query
    $stmt->execute();
    
    echo "Event updated successfully.";
} catch (PDOException $e) {
    // Log the error and return an error message
    error_log("Database error: " . $e->getMessage());
    die("An error occurred while updating the event. Please try again later.");
} finally {
    // Close the connection
    $conn = null;
}
?>
