<?php
session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}


// Ensure CSRF token is initialized
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once __DIR__ . '/../../db_connect.php';

// Fetch post data based on ID
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT title, category_id, description, post_thumbnail, author FROM posts WHERE id = ?");
    $stmt->bind_param('i', $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    } else {
        exit('Post not found.');
    }

    $stmt->close();
} else {
    exit('Post ID not specified.');
}

// Update post in database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_SESSION['csrf_token'] !== $_POST['csrf_token']) {
        exit("Invalid CSRF token. Please try again.");
    }

    // Sanitize inputs
    $title = htmlspecialchars($_POST['title']);
    $category_id = intval($_POST['category_id']);
    $description = $_POST['description']; // Quill editor content
    $author = htmlspecialchars($_POST['author']);

    // Handle image upload if a new image is provided
    if (!empty($_FILES['image']['name'])) {
        $upload_dir = '../../uploads/';
        $image_name = basename($_FILES['image']['name']);
        $target_file = $upload_dir . $image_name;

        // Check file type and size
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($file_type, $allowed_types)) {
            exit('Only JPG, JPEG, PNG, and GIF files are allowed.');
        }
        if ($_FILES['image']['size'] > 5000000) { // 5MB limit
            exit('File size exceeds maximum limit.');
        }

        // Move uploaded file to designated directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $post_thumbnail = $target_file;
        } else {
            exit('Failed to upload image.');
        }
    } else {
        // Keep existing image path
        $post_thumbnail = $post['post_thumbnail'];
    }

    // Update post in database
    $stmt = $conn->prepare("UPDATE posts SET title = ?, category_id = ?, description = ?, post_thumbnail = ?, author = ? WHERE id = ?");
    $stmt->bind_param('sisssi', $title, $category_id, $description, $post_thumbnail, $author, $post_id);

    if ($stmt->execute()) {
        // Post updated successfully
        $_SESSION['message'] = 'Post updated successfully.';
        header("Location: manage_posts.php");
        exit;
    } else {
        // Error occurred
        $_SESSION['message'] = 'Error updating post.';
        header("Location: manage_posts.php");
        exit;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <style>
        .form-control-file {
            margin-top: 10px;
        }
    </style>
    <script>
        $(document).ready(function () {
            const quill = new Quill('#editor', {
                theme: 'snow',
                placeholder: 'Compose an epic...',
                modules: {
                    toolbar: [
                        [{ 'header': '1' }, { 'header': '2' }, { 'font': [] }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'align': [] }],
                        ['link', 'image', 'video'],
                        ['clean']
                    ]
                }
            });

            // Set initial content for Quill editor
            var editorContent = <?php echo json_encode($post['description']); ?>;
            if (editorContent) {
                quill.root.innerHTML = editorContent;
                $('#description').val(editorContent); // Sync with hidden textarea
            }

            // Sync Quill content with hidden textarea on editor change
            quill.on('text-change', function () {
                $('#description').val(quill.root.innerHTML);
            });

            // Remove previous CSRF token on form submission
            $('form').on('submit', function () {
                $(this).find('input[name="csrf_token"]').remove();
            });
        });
    </script>
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
            <li><a class="dropdown-item" href="categories_management.php">Category Manager</a></li>
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
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Edit Post</h5>
            </div>
            <div class="card-body">
                <!-- Form to edit post -->
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $post_id); ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <?php
                            // Fetch categories from database and populate the select options
                            $result = $conn->query("SELECT ID, category_name FROM post_category");
                            while ($row = $result->fetch_assoc()) {
                                $selected = ($row['ID'] == $post['category_id']) ? 'selected' : '';
                                echo "<option value='" . $row['ID'] . "' $selected>" . $row['category_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editor" class="form-label">Content</label>
                        <div id="editor" style="height: 200px;"></div>
                        <textarea id="description" name="description" style="display:none;"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Image</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($post['author']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Post</button>
                    <a href="manage_posts.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

