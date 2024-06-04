<?php
session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
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
    <title>Create New Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
   
</head>

<body>
<script>
        $(document).ready(function() {
            const quill = new Quill('#editor', {
                theme: 'snow',
                placeholder: 'Compose an epic...',
                modules: {
                    toolbar: [
                        [{ 'header': '1'}, {'header': '2'}, { 'font': [] }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [ 'bold', 'italic', 'underline', 'strike' ],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'align': [] }],
                        [ 'link', 'image', 'video' ],
                        [ 'clean' ]
                    ]
                }
            });

            // Sync Quill content with hidden textarea on form submission
            $('form').on('submit', function() {
                $('#description').val(quill.root.innerHTML);
            });
        });
    </script>

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
            <li><a class="dropdown-item" href="categories_management.php">Category Manager</a></li>
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
                <h5 class="card-title">Create New Post</h5>
            </div>
            <div class="card-body">
                <!-- Form to submit new post -->
                <form action="post_upload_process.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            <?php
require_once __DIR__ . '/../../db_connect.php';

// Prepare SQL statement
$sql = "SELECT ID, category_name FROM post_category";
$stmt = $conn->prepare($sql);

// Execute the query
$stmt->execute();

// Fetch all rows as an associative array
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output the options
foreach ($categories as $category) {
    echo "<option value='" . $category['ID'] . "'>" . $category['category_name'] . "</option>";
}
?>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editor" class="form-label">Content</label>
                        <div id="editor" style="height: 600px;"></div>
                        <textarea id="description" name="description" style="display:none;"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    
                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" class="form-control" id="author" name="author" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save Post</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
