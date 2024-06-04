

<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Icym Ahmedabad</title>

    <!-- local stylesheets -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Local library links -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/easing.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/waypoints.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Font -->
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

    <!-- local stylesheets -->
    <link rel="stylesheet" href="css/style.css">
<?php

// Prepare SQL statement
$sql = "SELECT id, title, description, upload_date, post_thumbnail, author FROM posts ORDER BY upload_date DESC LIMIT 3";
$pdo = $conn;
$stmt = $pdo->query($sql);

// Fetch posts
$posts = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $posts[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'description' => $row['description'],
        'upload_date' => $row['upload_date'],
        'post_thumbnail' => $row['post_thumbnail'],
        'author' => $row['author']
    ];
}

// Close statement
$stmt = null;

?>

  <?php

$sql = "SELECT * FROM events ORDER BY created_at DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$recentEvent = $stmt->fetch(PDO::FETCH_ASSOC);
?>
  <style type="text/css">
      .post-container {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.post-thumbnail-container {
    width: 230px; /* Fixed width for the thumbnail */
    height: 180px; /* Fixed height for the thumbnail */
    overflow: hidden; /* Ensure thumbnail does not overflow */
    margin-right: 20px; /* Space between thumbnail and details */
}

.post-thumbnail {
    width: 100%; /* Make the image fill the container */
    height: auto; /* Maintain aspect ratio */
}

.post-details {
    flex: 1; /* Take remaining space */
}

.title {
    font-size: 24px; /* Example size for the title */
    margin-bottom: 10px;
}

.post-meta {
    font-size: 16px; /* Example size for meta information */
    margin-bottom: 5px;
}

  </style>
</head>

<body>

 <nav class="navbar navbar-expand-lg bg-body-tertiary text-center  fs-5">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="icym_25.png" alt="Logo" id="navbar-logo" style="max-height: 100px; max-width: 100px;" onerror="this.onerror=null;this.src='alternative_logo.png';">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="posts/">Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="news/">YouCat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="news/">Daily News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="calendar/">Coming Events Calendar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="jobs/">Job Offers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="magazines/">Magazines</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="gallery/">Gallery</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


    <div class="container-fluid mt-3 mb-3 p-2" style="background-color: #FBFCF8;">
    <div class="row align-items-center text-center">
      <div class="col-12 col-md-3 mb-3 mb-md-0"> 
        <img src="icym_25.png" alt="Logo 2" class="img-fluid logo" height="100px" width="100px">
       
      </div>
      <div class="col-12 col-md-6">
        <h1 class="display-4" style="color: #CC5500 ;font-weight: 700;"><span style="font-size : 39px;color: darkred;">25</span> YEARS OF ICYM</h1>
      </div>
      <div class="col-12 col-md-3 mt-3 mt-md-0">
         <img src="logo-1.jpg" alt="Logo 1" class="img-fluid logo" height="100px" width="100px" style="border-radius: 50%;">
      </div>
    </div>
  </div>


    <div class="container ">
        <div id="heroCarousel" class="carousel slide icyminfo" data-bs-ride="carousel"
            style="background-image: url(img/carousel_bg.png);border-radius:24px">
            <div class="carousel-inner p-3">
                <div class="carousel-item active">
                    <div class="container mt-5">
                        <div class="row justify-content-between gy-5">
                            <div class="col-lg-5 text-center text-lg-start">
                                <img src="img/logo-1-modified.png" class="img-fluid animated fadeInRight" alt=""
                                    data-aos="zoom-out" data-aos-delay="300"
                                    style="object-fit: cover; object-fit: contain; overflow: hidden; height: 90%; width: 90%;">
                            </div>
                            <div
                                class="col-lg-5 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start">
                                <h2 data-aos="fade-up" class="animated fadeInRightBig">ICYM - Ahmedabad Diocese</h2>
                                <p data-aos="fade-up" class="animated fadeInLeftBig" data-aos-delay="100"
                                    style="font-size: 22px;">ICYM Ahmedabad Diocese is a progressive institution that is
                                    working constantly for the yout....</p>
                                <a href="" class="me-2"><button type="button"
                                        class="btn btn-primary rounded-pill carousel-content-btn1 animated fadeInLeft">Take
                                        a look</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container mt-5">
                        <div class="row justify-content-between gy-5">
                            <div class="col-lg-5 text-center text-lg-start">
                                <img src="img/logo-2.png" class="img-fluid animated fadeInLeft" alt=""
                                    data-aos="zoom-out" data-aos-delay="300"
                                    style="object-fit: cover; object-fit: contain; overflow: hidden; height: 90%; width: 90%;">
                            </div>
                            <div
                                class="col-lg-5 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start">
                                <h2 data-aos="fade-up" class="animated fadeInLeftBig">ICYM - Ahmedabad Diocese</h2>
                                <p data-aos="fade-up" class="animated fadeInRightBig" data-aos-delay="100"
                                    style="font-size: 22px;">ICYM Ahmedabad Diocese is a progressive institution that is
                                    working constantly for the yout....</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Carousel controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="visually-hidden" aria-hidden="true"><i class="fa-solid fa-arrow-left caro-btn"></i></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="visually-hidden" aria-hidden="true"><i class="fa-solid fa-arrow-right caro-btn"></i></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    

  <div class="container mt-4 videos">
    <div class="row justify-content-center">
        <div class="col-md-6 mb-3">
            <div class="embed-responsive embed-responsive-16by9">
                <h1 class="text-center">યુવામુખે પ્રભુવાણી</h1>
                   <iframe class="embed-responsive-item video-iframe"
  src="https://www.youtube.com/embed?listType=playlist&list=UU8YCJxkNR9_S4S5pWiw8qFg">
</iframe>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="embed-responsive embed-responsive-16by9">
                <h1 class="text-center">Recommended</h1>
                <iframe class="embed-responsive-item video-iframe" src="https://www.youtube.com/embed/wL5j1U8BVls"
                    allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>


  <div class="container mt-5 recent_event p-2">
        <h1 class="mb-4 mt-5 text-center " style="font-weight : bold ; text-decoration: underline;" >Latest Posts</h1>

        <?php foreach ($posts as $post): ?>
        <div class="post-container">
    <div class="post-thumbnail-container">
        <img src="posts/<?php echo htmlspecialchars($post['post_thumbnail']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="post-thumbnail" loading="lazy">
    </div>
    <div class="post-details">
        <h2 class="title"><?php echo htmlspecialchars($post['title']); ?></h2>
        <p class="post-meta"><strong>Upload Date:</strong> <?php echo htmlspecialchars($post['upload_date']); ?></p>
        <p class="post-meta"><strong>Author:</strong> <?php echo htmlspecialchars($post['author']); ?></p>
        <a href="posts/view_post.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Read More</a>
        <hr>
    </div>
</div>

        <?php endforeach; ?>

    </div>

    <!-- recent events -->
    <div class="recent_event container py-3 my-5" style="background-color: wheat; font-weight: 900">
        <div class="container pt-5">
            <div class="row g-5">
                <div class="col-lg-5 col-md-6 col-sm-12 wow fadeIn" data-wow-delay=".3s">
                    <div class="h-100 position-relative">
                       <img src="admin/recent_event/<?php echo $recentEvent['image']; ?>" class="img-fluid rounded animated fadeInDown" alt="<?php echo $recentEvent['title']; ?>" style = "max-height: 490px;">

                    </div>
                </div>
                <div class="col-lg-7 col-md-6 col-sm-12 wow fadeIn" data-wow-delay=".5s">
                    <h1 class="text-primary">Recent Events</h1>
                    <h2 class="mb-4"><?php echo $recentEvent['title']; ?></h2>
                    <p></p>
                    <p class="mb-4" style="color: black;"><?php echo $recentEvent['description']; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>


   
    <!-- JavaScript CDN -->
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->

</body>

</html>
