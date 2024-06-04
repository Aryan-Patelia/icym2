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

if ($id === false) {
    die("Invalid input.");
}

try {
    // Prepare the SQL query using a placeholder
    $sqlDelete = "DELETE FROM tbl_events WHERE id = :id";
    $stmt = $conn->prepare($sqlDelete);

    // Bind the parameter to the query
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the query
    $stmt->execute();
    
    // Output the number of affected rows
    echo $stmt->rowCount();
} catch (PDOException $e) {
    // Log the error and return an error message
    error_log("Database error: " . $e->getMessage());
    die("An error occurred while deleting the event. Please try again later.");
} finally {
    // Close the connection
    $conn = null;
}
?>
