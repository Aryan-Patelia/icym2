<?php include '../session.php' ?>
<?php include 'header.php'  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Blog Posts</title>

    <style>
        body {
           
            background-color: #f5f5f5;
        }

        .container {
            margin-top: 20px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            background-color: #fff;
            word-wrap: break-word;
            white-space: pre-line;
        }
        .container:hover{
            cursor : grab;
        }

        .post-container {
            display: flex;
            flex-wrap: nowrap;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            background-color: #fff;
            word-wrap: break-word;
            white-space: pre-line;
        }

        .post-thumbnail {
            width: 100%;
            max-width: 250px;
            height: auto;
            margin-right: 2rem;
            border-radius: 5px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .post-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .post-content p {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2; 
            -webkit-box-orient: vertical;
            font-size: 20px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .post-meta {
            font-size: 14px; /* Reduced font size for smaller screens */
            color: #666;
            margin-bottom: 5px; /* Adjusted margin for better spacing */
        }

        @media (max-width: 991.98px) {
            .post-container {
                flex-wrap: wrap;
            }
            .post-thumbnail {
                width: 100%;
                max-width: none;
                margin-right: 0;
                margin-bottom: 1rem;
            }
            .post-content {
               display:flex;
            }
            
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const postContainers = document.querySelectorAll('.post-container');
            postContainers.forEach(container => {
                container.addEventListener('click', function() {
                    window.location.href = this.getAttribute('data-url');
                });
            });
        });
    </script>
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
                    <a class="nav-link" href="#">Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href=../youcat>YouCat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../news/">Daily News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../calendar/">Coming Events Calendar</a>
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

    <div class="container" style=" font-family: 'Montserrat', sans-serif;">
        <?php 
            $rows = $posts->getPosts();

            foreach ($rows as $row) {
                if ($row['published']) {
                    $postUrl = 'view_post.php?id=' . htmlspecialchars($row['id']);
                    echo "<div class='post-container' data-url='$postUrl'>";
                  echo "<img src='thumbnails/" . $row['post_thumbnail'] . "' alt='" . htmlspecialchars($row['Title']) . "' class='post-thumbnail'>";

                    echo "<div class='post-content'>";
                    echo "<h2 class='title'>" . htmlspecialchars($row['Title']) . "</h2>";
                    echo "<p class='post-meta'><strong>Upload Date:</strong> " . htmlspecialchars($row['upload_date']) . "</p>";
                    echo "<p class='post-meta'><strong>Author:</strong> " . htmlspecialchars($row['author']) . "</p>";
                    echo "</div>";
                    echo "</div>";
                }
            }
        ?>
    </div>

    <!-- JavaScript CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>
</html>
