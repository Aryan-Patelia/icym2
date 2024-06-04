
<?php
require_once __DIR__ . '/../db_connect.php';

try {
    // Create a PDO instance
    $pdo = $conn;
    
    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Prepare SQL statement to fetch magazines
    $stmt = $pdo->query("SELECT title, banner, pdf_path, upload_date FROM magazines ORDER BY upload_date DESC");
    
    // Fetch all magazines
    $magazines = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle database connection errors
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Magazine Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
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
                    <a class="nav-link" href="#">Magazines</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../gallery/">Gallery</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="container mt-5">
        <div class="row">
            <?php if (!empty($magazines)): ?>
                <?php foreach ($magazines as $magazine): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($magazine['banner']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($magazine['title']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($magazine['title']); ?></h5>
                            <a href="<?php echo htmlspecialchars($magazine['pdf_path']); ?>" class="btn btn-primary" target="_blank">Read Magazine</a>
                        </div>
                        <div class="card-footer text-muted">
                            Uploaded on <?php echo date('d-m-Y', strtotime($magazine['upload_date'])); ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info" role="alert">
                        No magazines found.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
