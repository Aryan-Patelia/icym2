
<?php


// Security check: Ensure user is authenticated before proceeding

require_once '../db_connect.php';

// Function to safely output HTML attributes
function html_attr($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

try {
    // Create a PDO instance
    $pdo = $conn;
    
    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection errors
    die("Connection failed: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Image Gallery</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        .folder-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 20px;
            margin-bottom: 20px;
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
            border-radius: 15px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            height: 100px;
        }
        .folder-box:hover {
            transform: translateY(-5px);
        }
        .folder-box h3 {
            margin-bottom: 0;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary text-center  fs-5">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">
            <img src="../icym_25.png" alt="Logo" id="navbar-logo" style="max-height: 100px; max-width: 100px;" onerror="this.onerror=null;this.src='alternative_logo.png';">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../posts/">Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../youcat">YouCat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../news/">Daily News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../calendar">Coming Events Calendar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../jobs/">Job Offers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../magazines/">Magazines</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Gallery</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div class="container mt-5">
    <div class="row">
        <div class="col text-center mb-3">
            <h1>Image Gallery</h1>
        </div>
    </div>

    <!-- Folders Display -->
    <div class="row mt-3">
        <?php
        // Prepare SQL statement to fetch image folders
        $stmt = $pdo->query("SELECT * FROM tbl_image_folder");
        
        // Loop through the results and display each folder
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $folderID = html_attr($row['tbl_image_folder_id']);
            $folderName = html_attr($row['folder_name']);
            echo "<div class='col-md-4'>
                    <div class='folder-box text-center' onclick=\"window.location.href='display_images.php?folder_id=$folderID'\">
                        <h3>$folderName</h3>
                    </div>
                  </div>";
        }
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
