<?php
session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

require_once '../../db_connect.php';

// Function to safely output HTML attributes
function html_attr($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Image Gallery</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <style>
        .folder-nav {
            margin-bottom: 1rem;
        }
        .folder-tab-content {
            margin-bottom: 1rem;
        }
        .add-buttons {
            display: flex;
            justify-content: flex-start;
            gap: 1rem;
        }
        .image-container {
            width: 180px;
            height: 180px;
            overflow: hidden;
        }
        .image-container img {
            object-fit: cover;
            width: 100%;
            height: 100%;
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
          <a class="nav-link" href="../jobs">Job Offer Uploading</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../recent_event">Recent Event Update</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../calendar">Upcoming Events</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Gallery Management</a>
        </li>
          <li class="nav-item">
          <a class="nav-link" href="../magazines">Magazines Uploading</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col">
            <h1>Image Gallery</h1>
        </div>
    </div>

    <div class="row add-buttons">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFolderModal">Add Folder</button>
        <button type="button" class="btn btn-success d-none" id="addImageBtn" data-toggle="modal" data-target="#addImageModal">Add Image</button>
    </div>

    <!-- Folders Navigation -->
    <div class="row mt-3 folder-nav">
        <div class="col">
            <ul class="nav nav-tabs" id="foldersTab" role="tablist">
                <?php
                // Assuming $conn is your PDO connection

                $query = "SELECT * FROM tbl_image_folder";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $folders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($folders as $folder) {
                    $folderID = $folder['tbl_image_folder_id'];
                    $folderName = htmlspecialchars($folder['folder_name']);
                    echo "<li class='nav-item'>
                            <a class='nav-link' id='folder-$folderID-tab' data-toggle='tab' href='#folder-$folderID' role='tab' aria-controls='folder-$folderID' aria-selected='true'>$folderName</a>
                          </li>";
                }
                ?>
            </ul>
        </div>
    </div>

    <!-- Image Display -->
    <div class="tab-content folder-tab-content" id="foldersTabContent">
        <?php
        foreach ($folders as $folder) {
            $folderID = $folder['tbl_image_folder_id'];

            $stmtImages = $conn->prepare("SELECT * FROM tbl_image WHERE tbl_image_folder_id = ?");
            $stmtImages->execute([$folderID]);
            $images = $stmtImages->fetchAll(PDO::FETCH_ASSOC);

            echo "<div class='tab-pane fade' id='folder-$folderID' role='tabpanel' aria-labelledby='folder-$folderID-tab'>";
            echo "<div class='row'>";
            foreach ($images as $image) {
                $imageName = htmlspecialchars($image['image_name']);
                echo "<div class='col-3 mb-4'>
                        <div class='image-container'>
                          <a href='./images/$imageName' data-lightbox='gallery' data-title=''><img src='./images/$imageName' class='img-fluid' alt='Image'></a>
                        </div>
                      </div>";
            }
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>

    <!-- Add Folder Modal -->
    <div class="modal fade" id="addFolderModal" tabindex="-1" role="dialog" aria-labelledby="addFolderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFolderModalLabel">Add Folder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="add-folder.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="folderName">Folder Name</label>
                            <input type="text" class="form-control" id="folderName" name="folder_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Folder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Image Modal -->
    <div class="modal fade" id="addImageModal" tabindex="-1" role="dialog" aria-labelledby="addImageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addImageModalLabel">Add Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="add-image.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="imageFolder">Select Folder</label>
                            <select class="form-control" id="imageFolder" name="tbl_image_folder_id" required>
                                <option value="">Select Folder</option>
                                <?php
                                $query = "SELECT * FROM tbl_image_folder";
                                $result = $conn->query($query);
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    $folderID = $row['tbl_image_folder_id'];
                                    $folderName = html_attr($row['folder_name']);
                                    echo "<option value='$folderID'>$folderName</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="imageFile">Choose Images</label>
                            <input type="file" class="form-control-file" id="imageFile" name="image_names[]" multiple required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add Images</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
    $(document).ready(function() {
        // Show Add Image button when a folder tab is selected
        $('#foldersTab a').on('shown.bs.tab', function (e) {
            $('#addImageBtn').removeClass('d-none');
        });
    });
</script>

</body>
</html>
