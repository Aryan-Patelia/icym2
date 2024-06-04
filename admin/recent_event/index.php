<?php
session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

require_once '../../db_connect.php';

// Fetch recent event details from the database
$sql = "SELECT * FROM events ORDER BY created_at DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$recentEvent = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">
      <img src="../icym_25.png" alt="Logo" style="max-height: 100px;max-width: 100px;">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Post Management
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../posts">Post Manager</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../posts/categories_management.php">Category Manager</a></li>
          </ul>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="../jobs">Job Offer Uploading</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Recent Event Update</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../calendar">Upcoming Events</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../gallery">Gallery Management</a>
        </li>
          <li class="nav-item">
          <a class="nav-link" href="../magazines">Magazines Uploading</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<div class="container mt-5">
    <h1 class="mb-4">Manage Events</h1>

    <!-- Event Form -->
    <div class="card mb-4">
        <div class="card-header">Add New Event</div>
        <div class="card-body">
            <form action="add_event.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="eventTitle" class="form-label">Event Title</label>
                    <input type="text" class="form-control" id="eventTitle" name="event_title" required>
                </div>
                <div class="mb-3">
                    <label for="eventDescription" class="form-label">Event Description</label>
                    <textarea class="form-control" id="eventDescription" name="event_description" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="eventImage" class="form-label">Event Image</label>
                    <input type="file" class="form-control" id="eventImage" name="event_image" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Event</button>
            </form>
        </div>
    </div>

    <!-- Recent Events Section -->
    <div class="recent_event container py-3 my-5" style="background-color: wheat; font-weight: 900;">
        <div class="container pt-5">
            <div class="row g-5">
                <div class="col-lg-5 col-md-6 col-sm-12 wow fadeIn" data-wow-delay=".3s">
                    <div class="h-100 position-relative">
                        <img src="<?php echo $recentEvent['image']; ?>" class="img-fluid rounded animated fadeInDown" alt="<?php echo $recentEvent['title']; ?>" style = "max-height: 490px;">
                    </div>
                </div>
                <div class="col-lg-7 col-md-6 col-sm-12 wow fadeIn" data-wow-delay=".5s">
                    <h1 class="text-primary">Recent Events</h1>
                    <h2 class="mb-4"><?php echo $recentEvent['title']; ?></h2>
                    <p></p>
                    <p class="mb-4" style="color: black;"><?php echo $recentEvent['description']; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
