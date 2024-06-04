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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add Job Offer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <style>
        .job-form {
            max-width: 800px;
            margin: 50px auto;
        }
    </style>
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
          <a class="nav-link" href="#">Job Offer Uploading</a>
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
    <div class="container job-form">
        <h2 class="text-center">Add Job Offer</h2>
        <form action="job_upload_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <div class="mb-3">
                <label for="job_type" class="form-label">Job Offer Type</label>
                <select class="form-select" id="job_type" name="job_type" required>
                    <option value="">Select Type</option>
                    <option value="text">Text-based</option>
                    <option value="photo">Photo-based</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Job Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3" id="text-editor-container" style="display: none;">
                <label for="description" class="form-label">Description</label>
                <div id="editor" style="height: 200px;"></div>
                <textarea id="description" name="description" style="display:none;"></textarea>
            </div>

            <div class="mb-3" id="image-upload-container" style="display: none;">
                <label for="image" class="form-label">Upload Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>

            <button type="submit" class="btn btn-primary">Save Job Offer</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            const quill = new Quill('#editor', {
                theme: 'snow'
            });

            $('#job_type').on('change', function() {
                const jobType = $(this).val();
                if (jobType === 'text') {
                    $('#text-editor-container').show();
                    $('#image-upload-container').hide();
                } else if (jobType === 'photo') {
                    $('#text-editor-container').hide();
                    $('#image-upload-container').show();
                } else {
                    $('#text-editor-container').hide();
                    $('#image-upload-container').hide();
                }
            });

            $('form').on('submit', function() {
                $('#description').val(quill.root.innerHTML);
            });
        });
    </script>
</body>
</html>
