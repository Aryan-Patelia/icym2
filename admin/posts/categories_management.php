<?php
session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

require_once __DIR__ . '/../../db_connect.php';

$updateSuccess = false; // Track if the update was successful

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // CSRF token validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed.");
    }

    // Check action type
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        switch ($action) {
            case 'add':
                $category_name = $_POST['category_name'];
                try {
                    $stmt = $conn->prepare("INSERT INTO post_category (category_name) VALUES (?)");
                    $stmt->execute([$category_name]);
                    echo "Category added successfully.";
                } catch (PDOException $e) {
                    echo "Error adding category: " . $e->getMessage();
                }
                break;
            case 'edit':
                $category_id = $_POST['category_id'];
                $category_name = $_POST['category_name'];
                try {
                    $stmt = $conn->prepare("UPDATE post_category SET category_name = ? WHERE id = ?");
                    $stmt->execute([$category_name, $category_id]);
                    $updateSuccess = true;
                } catch (PDOException $e) {
                    echo "Error updating category: " . $e->getMessage();
                }
                break;
            case 'delete':
                $category_id = $_POST['category_id'];
                try {
                    $stmt = $conn->prepare("DELETE FROM post_category WHERE id = ?");
                    $stmt->execute([$category_id]);
                    echo "Category deleted successfully.";
                } catch (PDOException $e) {
                    echo "Error deleting category: " . $e->getMessage();
                }
                break;
            default:
                echo "Invalid action.";
                break;
        }
    }
}

// Fetch all categories
try {
    $stmt = $conn->query("SELECT id, category_name FROM post_category");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching categories: " . $e->getMessage();
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
    <title>Manage Post Categories</title>
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
            <li><a class="dropdown-item" href="index.php">Post Manager</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Category Manager</a></li>
          </ul>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="../jobs">Job Offer Uploading</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../recent_event">Recent Event Update</a>
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
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Manage Post Categories</h5>
            </div>
            <div class="card-body">
                <!-- Add Category Form -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="mb-3">
                        <label for="category_name" class="form-label">New Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="action" value="add">Add Category</button>
                </form>
                <hr>
                <!-- List Categories -->
                <h5>Existing Categories</h5>
                <ul class="list-group">
                    <?php foreach ($categories as $category): ?>
                        <li class="list-group-item">
                            <?php echo htmlspecialchars($category['category_name']); ?>
                            <div class="float-end">
                                <!-- Edit Category Form -->
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="d-inline">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                                    <input type="text" class="form-control form-control-sm d-inline-block" style="width: 150px;" name="category_name" value="<?php echo htmlspecialchars($category['category_name']); ?>" required>
                                    <button type="submit" class="btn btn-sm btn-success" name="action" value="edit">Update</button>
                                </form>
                                <!-- Delete Category Form -->
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="d-inline">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" name="action" value="delete">Delete</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
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
                    Category updated successfully.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php if ($updateSuccess): ?>
    <script>
        var successModal = new bootstrap.Modal(document.getElementById('successModal'), {});
        successModal.show();
    </script>
    <?php endif; ?>
</body>

</html>
