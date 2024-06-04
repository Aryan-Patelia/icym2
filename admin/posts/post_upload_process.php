<?php
session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}


// Include database connection configuration
require_once __DIR__ . '/../../db_connect.php';

// Function to generate CSRF token
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

// Function to handle file upload
function handleFileUpload($file, $upload_dir) {
    $filename = basename($file['name']);
    $target_path = $upload_dir . $filename;
    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return $filename;
    } else {
        return null;
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed.");
    }

    // Retrieve form data
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description']; // This will be the HTML content from Quill editor
    $upload_date = date('Y-m-d'); // Current date
    $author = $_POST['author'];

    // File upload handling (if image upload is enabled)
    $post_thumbnail = null; // Initialize as null initially
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../posts/thumbnails/'; // Directory to store uploaded files
        $post_thumbnail = handleFileUpload($_FILES['image'], $upload_dir);
        if (!$post_thumbnail) {
            die("Failed to upload image file.");
        }
    }

    try {
        // Create a PDO instance
        
        $pdo = $conn;
        
        // Set PDO to throw exceptions on error
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL query to insert data into database
        $sql = "INSERT INTO posts (title, description, upload_date, post_thumbnail, category_id, author, published) 
                VALUES (:title, :description, :upload_date, :post_thumbnail, :category_id, :author, NULL)";

        // Prepare the SQL statement
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':upload_date', $upload_date);
        $stmt->bindParam(':post_thumbnail', $post_thumbnail);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':author', $author);

        // Execute the SQL statement
        if ($stmt->execute()) {
            echo "New post created successfully.";
        } else {
            echo "Error: Unable to execute query.";
        }

        // Close the connection
        $pdo = null;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo "Form submission error.";
}

// Generate CSRF token
generateCSRFToken();
?>
