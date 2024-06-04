
<?php


// Security check: Ensure user is authenticated before proceeding

require_once '../db_connect.php';

// Function to safely output HTML attributes
function html_attr($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

// Check if folder_id is provided in the URL
if (isset($_GET['folder_id'])) {
    $folderID = $_GET['folder_id'];
    $pdo = $conn;
    // Fetch folder name for display
    $stmtFolder = $pdo->prepare("SELECT folder_name FROM tbl_image_folder WHERE tbl_image_folder_id = ?");
    $stmtFolder->execute([$folderID]);
    $folderName = $stmtFolder->fetchColumn();
    $stmtFolder->closeCursor();

    // Fetch images for the selected folder
    $stmtImages = $pdo->prepare("SELECT * FROM tbl_image WHERE tbl_image_folder_id = ?");
    $stmtImages->execute([$folderID]);
    $images = $stmtImages->fetchAll(PDO::FETCH_ASSOC);
} else {
    // If folder_id is not provided in the URL, handle accordingly (redirect or error handling)
    // For simplicity, you can redirect to another page or display an error message.
    header("Location: index.php"); // Redirect to index.php or another suitable page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo html_attr($folderName); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="lightbox.css" rel="stylesheet" />
    <script src="lightbox.js"></script>
    <script src="lightbox-plus-jquery.js"></script>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
   
        .image-box a {
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .image-box {
            position: relative;
            width: 100%;
            padding-top: 100%;
            overflow: hidden;
            margin-bottom: 1rem;
        }
        .image-box img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body class="bg-gray-100">

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
                    <a class="nav-link" href="index.php">Gallery</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div class="container py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold"><?php echo html_attr($folderName); ?></h1>
    </div>

    <!-- Images Display -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-6 g-4">
        <?php foreach ($images as $image) : ?>
            <?php
            $imageName = html_attr($image['image_name']);
            ?>
            <div class="col-6 col-sm-6 col-md-3 col-lg-2">
                <div class="image-box">
                    <a href="../admin/gallery/images/<?php echo $imageName; ?>" data-lightbox="gallery" data-title="<?php echo html_attr($imageName); ?>">
                        <img src="../admin/gallery/images/<?php echo $imageName; ?>" class="img-fluid" alt="Image" loading = "lazy">
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    });
</script>
</body>
</html>
