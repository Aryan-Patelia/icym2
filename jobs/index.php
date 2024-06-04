
<?php
require_once __DIR__ . '/../db_connect.php'; 

// Fetch job offers from the database
$sql = "SELECT id, title, description, image_path, job_type FROM job_offers ORDER BY upload_date DESC";
$result = $conn->query($sql);

// Initialize array to store job offers
$jobOffers = [];

if ($result->rowCount() > 0) { // Adjusted line to use rowCount() method
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // Store all job offers in one array
        $jobOffers[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job Offers </title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <!-- Optional: Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <!-- Custom CSS for Roman Empire Vibe -->
  <link href="../css/style.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa; /* Light background */
    }
    .job-card {
      background-color: #f9fcff;
      background-image: linear-gradient(147deg, #f9fcff 0%, #dee4ea 74%);
      border: 3px solid black; /* Light border */
      border-radius: 10px; /* Rounded corners */
      box-shadow: 0 0 10px rgba(0,0,0,0.1); /* Soft shadow */
      margin-bottom: 20px;
      width: 100%; /* Set the width */
    }
    .job-card .card-body {
      padding: 20px;
      background: rgba(255, 255, 255, 0.5); /* Transparent white background */
      backdrop-filter: blur(10px); /* Blur effect */
      border-radius: 10px; /* Rounded corners */
    }
    .job-card .card-body h5 {
      font-size: 1.5rem;
      font-weight: bold;
      color: black; /* Dark text color */
      text-align: center; /* Center align title */
      margin-bottom: 1rem; /* Add space below title */
    }
    .job-card .card-body p {
      font-size: 1rem;
      color: #6c757d; /* Gray text color */
      text-align: center; /* Center align description */
    }
    .job-card .modal-header {
      background-color: #343a40; /* Dark header background */
      color: #fff; /* White text color */
      border-bottom: none; /* No bottom border */
    }
    .job-card .modal-body {
      background-color: #fff; /* White background */
      color: #343a40; /* Dark text color */
    }
    .job-card .modal-footer {
      background-color: #343a40; /* Dark footer background */
      border-top: none; /* No top border */
    }
    .job-card .btn-primary {
      background-color: #343a40; /* Dark button background */
      border-color: #343a40; /* Dark button border */
    }
    .job-card .btn-primary:hover {
      background-color: #23272b; /* Darken button on hover */
      border-color: #23272b; /* Darken button border on hover */
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary text-center  fs-5 mb-5">
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
  <div class="container">
    <div class="row justify-content-center">
      <?php foreach ($jobOffers as $key => $offer): ?>
        <div class="col-md-6">
          <div class="card job-card">
            <div class="card-body">
              <h5 class="card-title"><?php echo $offer['title']; ?></h5>
              <button type="button" class="btn btn-primary view-details-btn" data-bs-toggle="modal" data-bs-target="#jobModal<?php echo $offer['id']; ?>">
                View Details
              </button>
            </div>
          </div>
        </div>

        <!-- Modal for each job offer -->
        <div class="modal fade" id="jobModal<?php echo $offer['id']; ?>" tabindex="-1" aria-labelledby="jobModalLabel<?php echo $offer['id']; ?>" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h2 class="modal-title" id="jobModalLabel<?php echo $offer['id']; ?>"><?php echo $offer['title']; ?></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p><?php echo $offer['description']; ?></p>
                <?php if ($offer['job_type'] == 'photo'): ?>
                  <img src="<?php echo $offer['image_path']; ?>" class="img-fluid" alt="Job Photo">
                <?php endif; ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Bootstrap JS (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

