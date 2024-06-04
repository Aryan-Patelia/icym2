<?php
session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

require_once "../../db_connect.php";

// Sanitize and validate inputs
$title = isset($_POST['title']) ? filter_var(trim($_POST['title']), FILTER_SANITIZE_STRING) : "";
$start = isset($_POST['start']) ? filter_var(trim($_POST['start']), FILTER_SANITIZE_STRING) : "";
$end = isset($_POST['end']) ? filter_var(trim($_POST['end']), FILTER_SANITIZE_STRING) : "";

if (empty($title) || empty($start) || empty($end)) {
    die("Invalid input.");
}

try {

    $sqlInsert = "INSERT INTO tbl_events (title, start, end) VALUES (:title, :start, :end)";
    $stmt = $conn->prepare($sqlInsert);

    // Bind the parameters to the query
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':start', $start);
    $stmt->bindParam(':end', $end);

    // Execute the query
    $stmt->execute();

    echo "Event added successfully.";
} catch (PDOException $e) {

    error_log("Database error: " . $e->getMessage());
    echo "An error occurred while adding the event. Please try again later.";
} finally {
    // Close the connection
    $conn = null;
}
?>
