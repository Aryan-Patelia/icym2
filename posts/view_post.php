<?php
include "header.php";

// Fetch post details based on the ID passed in the URL
if (isset($_GET['id'])) {
    $post_id = intval($_GET['id']);

    // Fetching post details from database
    $post = $posts->getPostById($post_id);

    // Check if post exists
    if ($post) {
        // Display post details
        $title = $post['Title'];
        $description = $post['description'];
        $upload_date = $post['upload_date'];
        $author = $post['author'];
        $thumbnail = $post['post_thumbnail']; // Assuming this is how you retrieve the thumbnail

        // HTML structure for displaying post details
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo htmlspecialchars($title); ?></title>
            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
            <style>
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
            </style>
        </head>
        <body class="bg-gray-100">
            <div class="post-details py-8 px-4">
                <img src="thumbnails/<?php echo htmlspecialchars($thumbnail); ?>" alt="<?php echo htmlspecialchars($title); ?>" class="post-thumbnail">
                <h1 class="text-3xl font-bold text-center mt-4"><?php echo htmlspecialchars($title); ?></h1>
                <div class="post-content mt-4">
                    <p class="post-meta"><strong>Description:</strong> <?php echo htmlspecialchars($description); ?></p>
                    <p class="post-meta"><strong>Upload Date:</strong> <?php echo htmlspecialchars($upload_date); ?></p>
                    <p class="post-meta"><strong>Author:</strong> <?php echo htmlspecialchars($author); ?></p>
                </div>
            </div>
        </body>
        </html>
        <?php
    } else {
        // Handle case where post ID doesn't exist
        echo "Post not found.";
    }
} else {
    // Handle case where no ID is provided in the URL
    echo "No post ID specified.";
}
?>
