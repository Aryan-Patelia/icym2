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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Font -->
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

    <!-- local stylesheets -->
    <link rel="stylesheet" href="css/style.css">

   
</head>

<body>

    <?php require 'includes/navbar.php'; ?>
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
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="embed-responsive embed-responsive-16by9 ">
                    <h1 class="text-center">યુવામુખે પ્રભુવાણી</h1>
                    <iframe class="embed-responsive-item video-iframe"
                        src="https://www.youtube.com/embed/K0Hp75MarlU?si=MUJbZ_j1q-voYqCv" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="embed-responsive embed-responsive-16by9 ">
                    <h1 class="text-center">Recommended</h1>
                    <iframe class="embed-responsive-item video-iframe" src="https://www.youtube.com/embed/wL5j1U8BVls"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- recent events -->
    <div class="recent_event container py-5 my-5 " style="background-color : wheat;font-weight: 900;">
        <div class="container pt-5">
            <div class="row g-5">
                <div class="col-lg-5 col-md-6 col-sm-12 wow fadeIn" data-wow-delay=".3s">
                    <div class="h-100 position-relative">
                        <img src="img/recent_events/icym_day.jpg" class="img-fluid rounded animated fadeInDown" alt="">
                    </div>
                </div>
                <div class="col-lg-7 col-md-6 col-sm-12 wow fadeIn" data-wow-delay=".5s">
                    <h1 class="text-primary">Recent Events</h1>
                    <h2 class="mb-4">ICYM DAY - 2024</h2>
                    <p></p>
                    <p class="mb-4" style="color: black;">ICYM day 2024 -
                        <hr><span style="color: black;">The ICYM Day was celebrated on 24th January 2024 in
                            Karamsad.</span>
                        <hr> <span style="color: black;font-weight: 600;">What Happened there??</span><br><span
                            style="color: black;">1) our former Youth presidents were invited who motivated the youth
                            and also were honored.</span><br><span style="color: black;">2) ICYM Website
                            Launch</span><br><span style="color: black;">3) New Youth Committee was
                            Established</span><br><span style="color: black;">4) Overview of all the things happened in
                            ICYM Ahmebadad Diocese during 2023</span><br><span style="color: black;">5) Plans for 2024
                            were made
                    </p></span>
                </div>
            </div>
        </div>
    </div>


    <footer>
        <?php require 'includes/footer.php'; ?>
    </footer>

    <!-- JavaScript CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</body>

</html>
