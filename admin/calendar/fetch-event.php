<?php

session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

require_once "../../db_connect.php";

$json = array();

try {
    // Prepare and execute the SQL query
    $sqlQuery = "SELECT * FROM tbl_events ORDER BY id";
    $stmt = $conn->prepare($sqlQuery);
    $stmt->execute();

    // Fetch all results into an array
    $eventArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Encode the array to JSON format
    echo json_encode($eventArray);
} catch (PDOException $e) {
    // Log the error and return an error message
    error_log("Database error: " . $e->getMessage());
    echo json_encode(array("error" => "An error occurred while fetching events. Please try again later."));
} finally {
    // Close the connection
    $conn = null;
}
?>
