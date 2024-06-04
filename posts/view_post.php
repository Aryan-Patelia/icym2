<?php
include "header.php";

// Include PDO connection setup
require_once "../db_connect.php";

// Fetch post details based on the ID passed in the URL
if (isset($_GET['id'])) {
    $post_id = intval($_GET['id']);

    // Prepare SQL statement to fetch post details
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$post_id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if post exists
    if ($post) {
        // Display post details
        $title = htmlspecialchars($post['Title']);
        $description = $post['description'];
        $upload_date = $post['upload_date'];
        $author = $post['author'];
        $thumbnail = $post['post_thumbnail']; // Assuming this is how you retrieve the thumbnail
}}
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quill/2.0.2/quill.min.js" integrity="sha512-1nmY9t9/Iq3JU1fGf0OpNCn6uXMmwC1XYX9a6547vnfcjCY1KvU9TE5e8jHQvXBoEH7hcKLIbbOjneZ8HCeNLA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/2.0.2/quill.bubble.css" integrity="sha512-SCZUE/xdSmyGPpDqraRFVQwADKlDiUzFpZEBDF/fdH6HPYaB/vVWDyp+9tdN+XIEdjaQOmtRMXccvSxgdrRd4g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/2.0.2/quill.core.css" integrity="sha512-a7lWBqHHHcLWWynFie8nxZ2haAUHs34w7XiVra9AjlL+/XpDK1GOAGfzcAoLW978tD8/fym7JYxDxg8uPszyfw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            box-shadow: 2px 3px 20px black, 0 0 60px #8a4d0f inset;
            background: #fffef0;
        }
        .post-details {
            max-width: 700px;
            margin: auto;
            padding: 1rem;
        }
        .post-thumbnail {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
        .post-meta {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.5rem;
        }
        .ql-align-center {
            text-align: center;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css"
    integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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
                    <a class="nav-link" href="#">YouCat</a>
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
                    <a class="nav-link" href="../gallery/">Gallery</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="post-details py-8 px-4">
        <img src="<?php echo 'thumbnails/' . $thumbnail; ?>" alt="<?php echo $title; ?>" class="post-thumbnail">

        <h1 class="text-3xl font-bold text-center mt-4"><?php echo $title; ?></h1>
        <div class="post-content mt-4">
            <div id="editor">
                <p class="post-meta"><strong>Description:</strong> <?php echo $description; ?></p>
                <p class="post-meta"><strong>Upload Date:</strong> <?php echo $upload_date; ?></p>
                <p class="post-meta"><strong>Author:</strong> <?php echo $author; ?></p>
            </div>
        </div>
    </div>

    <script>
        var quill = new Quill('#editor', {
            theme: 'bubble',
            modules: {
                toolbar: [
                    [{ 'align': [] }],
                    ['bold', 'italic', 'underline'],
                    ['link', 'image']
                ]
            },
            readOnly: true
        });
    </script>
</body>
</html>
