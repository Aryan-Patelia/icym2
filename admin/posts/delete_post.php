<?php
session_start();

// Check if admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}

require_once __DIR__ . '/../../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'], $_GET['csrf_token'])) {
    $postId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $csrfToken = filter_input(INPUT_GET, 'csrf_token', FILTER_SANITIZE_STRING);

    if ($postId && $csrfToken && hash_equals($_SESSION['csrf_token'], $csrfToken)) {
        try {
            $sql = "DELETE FROM posts WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$postId]);
            $deletedRows = $stmt->rowCount(); // Check the number of deleted rows
            if ($deletedRows > 0) {
                $_SESSION['message'] = [
                    'type' => 'success',
                    'text' => 'Article has been deleted successfully.'
                ];
            } else {
                $_SESSION['message'] = [
                    'type' => 'danger',
                    'text' => 'Failed to delete article. Post not found or already deleted.'
                ];
            }
        } catch (PDOException $e) {
            $_SESSION['message'] = [
                'type' => 'danger',
                'text' => 'Error: ' . $e->getMessage()
            ];
        }
    } else {
        $_SESSION['message'] = [
            'type' => 'danger',
            'text' => 'Invalid CSRF token or missing parameters.'
        ];
    }
} else {
    $_SESSION['message'] = [
        'type' => 'danger',
        'text' => 'Invalid request method or missing parameters.'
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .container {
            margin-top: 100px;
            border-radius: 10px !important;
        }
        .message-box {
            background-color: #d4edda;
            border: 1px solid #155724;
            color: #155724;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .back-button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message-box">
            <h4><?php echo isset($_SESSION['message']) ? htmlspecialchars($_SESSION['message']['text']) : 'An error occurred.'; ?></h4>
            <a href="index.php" class="btn btn-primary back-button">Go Back</a>
        </div>
        <?php unset($_SESSION['message']); ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
