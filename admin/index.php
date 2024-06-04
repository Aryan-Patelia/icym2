<?php

session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            padding: 0;
            margin: 0;
        }
        .admin-panel {
            max-width: 1200px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .admin-panel h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .nav-card {
            margin-bottom: 20px;
        }
        .nav-link {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }
        .nav-link:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="admin-panel container">
        <h2>Welcome to the Admin Panel</h2>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card nav-card">
                    <div class="card-body">
                        <a href="posts/" class="card-link nav-link">Posts</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card nav-card">
                    <div class="card-body">
                        <a href="posts/categories_management.php" class="card-link nav-link">Post Categories</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card nav-card">
                    <div class="card-body">
                        <a href="magazines/" class="card-link nav-link">Magazines</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card nav-card">
                    <div class="card-body">
                        <a href="gallery/" class="card-link nav-link">Gallery</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card nav-card">
                    <div class="card-body">
                        <a href="jobs/" class="card-link nav-link">Job Offers</a>
                    </div>
                </div>
            </div>
        </div>
        
     
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
