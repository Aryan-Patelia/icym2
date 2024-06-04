<?php
session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}


// Function to handle file upload
function handleFileUpload($tmp_name, $upload_path) {
    return move_uploaded_file($tmp_name, $upload_path);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed.");
    }

    // Retrieve form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $upload_date = date('Y-m-d'); // Current date
    $job_type = $_POST['job_type']; // Retrieve job type

    // Initialize variables for file upload
    $upload_success = true; // Flag to track if any upload fails
    $upload_path = ''; // Initialize upload path variable

    // Check if an image file is uploaded (only if job_type is 'photo')
    if ($job_type === 'photo' && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // File upload handling
        $upload_dir = '../../jobs/uploads/';
        $filename = basename($_FILES['image']['name']);
        $tmp_name = $_FILES['image']['tmp_name'];
        $upload_path = $upload_dir . $filename;

        // Move uploaded file to designated directory
        if (!handleFileUpload($tmp_name, $upload_path)) {
            $upload_success = false;
            echo "Failed to upload image file.";
        }
    }

    // Proceed if image upload succeeded or no image was uploaded (for text-based job)
    if ($upload_success) {
        // Adjust the upload_path to store just the relative path (if job_type is 'photo')
        $relative_path = '';
        if ($job_type === 'photo') {
            $relative_path = 'uploads/' . $filename;
        }

        // Example: Insert into database using PDO
        require_once __DIR__ . '/../../db_connect.php'; // Adjust path as per your file structure

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO job_offers (title, description, image_path, upload_date, job_type) 
                    VALUES (:title, :description, :image_path, :upload_date, :job_type)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':image_path', $relative_path);
            $stmt->bindParam(':upload_date', $upload_date);
            $stmt->bindParam(':job_type', $job_type);

            $stmt->execute();
            echo "Job offer uploaded successfully.";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        
        $conn = null;
    }
} else {
    echo "Form submission error.";
}
?>
