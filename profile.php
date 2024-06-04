<?php
session_start();
require_once('db_connect.php');

// Ensure user is logged in
if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    header('Location: login.php');
    exit();
}

// Get user data
$user_id = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare("SELECT photo, name, gender, age, email, mobile, birthday, country, city, parish, education_occupation FROM users WHERE id = :id");
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found.");
    }
} catch(PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    die("An error occurred while retrieving your profile. Please try again later.");
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .profile-header img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .profile-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
     <nav class="navbar navbar-expand-lg bg-body-tertiary text-center  fs-5">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="icym_25.png" alt="Logo" id="navbar-logo" style="max-height: 100px; max-width: 100px;" onerror="this.onerror=null;this.src='alternative_logo.png';">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="posts/">Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="news/">YouCat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="news/">Daily News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="calendar/">Coming Events Calendar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="jobs/">Job Offers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="magazines/">Magazines</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="gallery/">Gallery</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="container">
        <div class="profile-header">
            <img src="<?php echo htmlspecialchars($user['photo'], ENT_QUOTES, 'UTF-8'); ?>" alt="User Photo">
            <h1><?php echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <p><?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="profile-card">
                    <h3>Profile Information</h3>
                    <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Age:</strong> <?php echo htmlspecialchars($user['age'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Mobile:</strong> <?php echo htmlspecialchars($user['mobile'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Birthday:</strong> <?php echo htmlspecialchars($user['birthday'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Country:</strong> <?php echo htmlspecialchars($user['country'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>City:</strong> <?php echo htmlspecialchars($user['city'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Parish:</strong> <?php echo htmlspecialchars($user['parish'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Education/Occupation:</strong> <?php echo htmlspecialchars($user['education_occupation'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
