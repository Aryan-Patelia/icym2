<?php
session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

require_once __DIR__ . '/../../db_connect.php';

$uploadSuccess = false;
$deleteSuccess = false;

// Handle form submission for uploading magazines
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload'])) {
    // CSRF token validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed.");
    }

    // Retrieve form data
    $title = $_POST['title'];

    // Handle banner upload
    $banner = null;
    if (isset($_FILES['banner']) && $_FILES['banner']['error'] === UPLOAD_ERR_OK) {
        $banner_dir = '../../admin/magazines/uploads/banners/';
        $banner_filename = basename($_FILES['banner']['name']);
        $banner_tmp_name = $_FILES['banner']['tmp_name'];
        $banner = '../admin/magazines/uploads/banners/' . $banner_filename;
        move_uploaded_file($banner_tmp_name, $banner_dir . $banner_filename);
    }

    // Handle PDF upload
    $pdf_path = null;
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
        $pdf_dir = '../../admin/magazines/uploads/';
        $pdf_filename = basename($_FILES['pdf']['name']);
        $pdf_tmp_name = $_FILES['pdf']['tmp_name'];
        $pdf_path = '../admin/magazines/uploads/' . $pdf_filename;
        move_uploaded_file($pdf_tmp_name, $pdf_dir . $pdf_filename);
    }

    // Insert data into database using PDO
    try {
        $stmt = $conn->prepare("INSERT INTO magazines (title, banner, pdf_path) VALUES (:title, :banner, :pdf_path)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':banner', $banner);
        $stmt->bindParam(':pdf_path', $pdf_path);
        if ($stmt->execute()) {
            $uploadSuccess = true;
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Handle deletion of magazines
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    // CSRF token validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed.");
    }

    // Retrieve the magazine ID to delete
    $magazine_id = $_POST['magazine_id'];

    // Delete the magazine from the database using PDO
    try {
        $stmt = $conn->prepare("DELETE FROM magazines WHERE id = :magazine_id");
        $stmt->bindParam(':magazine_id', $magazine_id);
        if ($stmt->execute()) {
            $deleteSuccess = true;
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Fetch all magazines
try {
    $stmt = $conn->prepare("SELECT id, title, banner, pdf_path, upload_date FROM magazines ORDER BY upload_date DESC");
    $stmt->execute();
    $magazines = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload Magazine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
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
          <a class="nav-link" href="#">Magazines Uploading</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

    <div class="container mt-5">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">Upload Magazine</h5>
            </div>
            <div class="card-body">
                <!-- Form to upload magazine -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="upload" value="1">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="banner" class="form-label">Banner Image</label>
                        <input type="file" class="form-control" id="banner" name="banner" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="pdf" class="form-label">Magazine PDF</label>
                        <input type="file" class="form-control" id="pdf" name="pdf" accept="application/pdf" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload Magazine</button>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">List of Magazines</h5>
            </div>
            <div class="card-body">
                <?php if ($deleteSuccess): ?>
                <div class="alert alert-success" role="alert">
                    Magazine deleted successfully.
                </div>
                <?php endif; ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Banner</th>
                            <th scope="col">PDF</th>
                            <th scope="col">Upload Date</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($magazines as $magazine): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($magazine['title']); ?></td>
                            <td><img src="<?php echo $magazine['banner']; ?>" alt="<?php echo htmlspecialchars($magazine['title']); ?>" width="100"></td>
                            <td><a href="<?php echo $magazine['pdf_path']; ?>" target="_blank">View PDF</a></td>
                            <td><?php echo date('d-m-Y', strtotime($magazine['upload_date'])); ?></td>
                            <td>
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display:inline;">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <input type="hidden" name="delete" value="1">
                                    <input type="hidden" name="magazine_id" value="<?php echo $magazine['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-success text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Success</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Magazine uploaded successfully.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($uploadSuccess): ?>
        <script>
            var successModal = new bootstrap.Modal(document.getElementById('successModal'), {});
            successModal.show();
        </script>
        <?php endif; ?>
    </div>
</body>

</html>
