<?php
session_start();
//TODO: dokleić tego ifa tam gdzie użytkownik musi być zalogowany
if (!isset($_SESSION['Logged'])) {
    header('Location: login_page.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en_US">
<head>
    <title>Page Title</title>

    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="main_page.css"/>

    <meta charset="UTF-8"/>
    <meta name="author" content="235967"/>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->


</head>

<body>
<!--navbar-->
<navbar>
    <ul class="nav-list">
        <li class="nav-item">
            <a href="#"><img class="logo" src="images/logo-no-background.png" alt=""></a>
        </li>
        <li class="nav-item">
            <a href="#">Search</a>
        </li>
        <li class="nav-item">
            <a href="profile_page_update.php">Profile</a>
        </li>
        <li class="nav-item">
            <a href="logout.php">Logout</a>
        </li>
    </ul>
</navbar>
<!--  searchbox -->
<div class="container-12">
    <div class="row__search">
        <div class="search-left">
            <input class="button--search input-mainpage" type="text" placeholder="Enter keyword">
            <button class="button--search">Search</button>
        </div>
    </div>
</div>
<!--  jobs-->
<!--    <div class="container-xxl">-->
<!--        <div class="container">-->
<!--            <div class="tab-content">-->
<!--                <div id="tab-1" class="tab-pane">-->
<!--                    <div class="job-item">-->
<!--                        <div class="row" >-->
<!--                            <div class="job-left">-->
<!--                                <img src="images/com-logo-1.jpg" alt="" style="width: 80px; height: 80px;">-->
<!--                                <div class="text-start">-->
<!--                                    <h5>Java Developer</h5>-->
<!--                                    <span class="text-truncate">-->
<!--                                        <i class="fa fa-map-marker-alt text--green me-2"></i>-->
<!--                                        "New York,Usa"-->
<!--                                    </span>-->
<!--                                    <span class="text-truncate">-->
<!--                                        <i class="fa fa-map-marker-alt text--green me-2"></i>-->
<!--                                        "New York,Usa"-->
<!--                                    </span>-->
<!--                                    <span class="text-truncate">-->
<!--                                        <i class="fa fa-map-marker-alt text--green me-2"></i>-->
<!--                                        "New York,Usa"-->
<!--                                    </span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="job-right">-->
<!---->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

<div class="container-xxl py-5">
    <div class="container">
        <div class="tab-class text-center wow fadeInUp">
            <div class="tab-content">
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <div class="job-item p-4 mb-4">
                        <div class="row g-4">
                            <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                <img class="flex-shrink-0 img-fluid border rounded" src="images/com-logo-1.jpg" alt="" style="width: 80px; height: 80px;">
                                <div class="text-start ps-4">
                                    <h5 class="job-title">Software Engineer</h5>
                                    <div class="job-discription">
                                        <span class="job-discription-item"><i class="fa fa-map-marker-alt text--green me-2"></i>New York, USA</span>
                                        <span class="job-discription-item"><i class="far fa-clock text--green me-2"></i>Full Time</span>
                                        <span class="job-discription-item"><i class="far fa-money-bill-alt text--green me-2"></i>$123 - $456</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                <div class="d-flex mb-3">
                                    <a class="btn btn-light btn-square me-3" href=""><i class="far fa-heart text--green"></i></a>
                                    <a class="button-standard button-primary" href="">Apply Now</a>
                                </div>
                                <div class="job-discription-date">
                                    <small class="job-discription-item"><i class="far fa-calendar-alt text--green me-2"></i>Date Line: 01 Jan, 2045</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="job-item p-4 mb-4">
                        <div class="row g-4">
                            <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                <img class="flex-shrink-0 img-fluid border rounded" src="images/com-logo-2.jpg" alt="" style="width: 80px; height: 80px;">
                                <div class="text-start ps-4">
                                    <h5 class="job-title">Software Engineer</h5>
                                    <div class="job-discription">
                                        <span class="job-discription-item"><i class="fa fa-map-marker-alt text--green me-2"></i>New York, USA</span>
                                        <span class="job-discription-item"><i class="far fa-clock text--green me-2"></i>Full Time</span>
                                        <span class="job-discription-item"><i class="far fa-money-bill-alt text--green me-2"></i>$123 - $456</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                <div class="d-flex mb-3">
                                    <a class="btn btn-light btn-square me-3" href=""><i class="far fa-heart text--green"></i></a>
                                    <a class="button-standard button-primary" href="">Apply Now</a>
                                </div>
                                <div class="job-discription-date">
                                    <small class="job-discription-item"><i class="far fa-calendar-alt text--green me-2"></i>Date Line: 01 Jan, 2045</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="job-item p-4 mb-4">
                        <div class="row g-4">
                            <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                <img class="flex-shrink-0 img-fluid border rounded" src="images/com-logo-3.jpg" alt="" style="width: 80px; height: 80px;">
                                <div class="text-start ps-4">
                                    <h5 class="job-title">Software Engineer</h5>
                                    <div class="job-discription">
                                        <span class="job-discription-item"><i class="fa fa-map-marker-alt text--green me-2"></i>New York, USA</span>
                                        <span class="job-discription-item"><i class="far fa-clock text--green me-2"></i>Full Time</span>
                                        <span class="job-discription-item"><i class="far fa-money-bill-alt text--green me-2"></i>$123 - $456</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                <div class="d-flex mb-3">
                                    <a class="btn btn-light btn-square me-3" href=""><i class="far fa-heart text--green"></i></a>
                                    <a class="button-standard button-primary" href="">Apply Now</a>
                                </div>
                                <div class="job-discription-date">
                                    <small class="job-discription-item"><i class="far fa-calendar-alt text--green me-2"></i>Date Line: 01 Jan, 2045</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="job-item p-4 mb-4">
                        <div class="row g-4">
                            <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                <img class="flex-shrink-0 img-fluid border rounded" src="images/com-logo-4.jpg" alt="" style="width: 80px; height: 80px;">
                                <div class="text-start ps-4">
                                    <h5 class="job-title">Software Engineer</h5>
                                    <div class="job-discription">
                                        <span class="job-discription-item"><i class="fa fa-map-marker-alt text--green me-2"></i>New York, USA</span>
                                        <span class="job-discription-item"><i class="far fa-clock text--green me-2"></i>Full Time</span>
                                        <span class="job-discription-item"><i class="far fa-money-bill-alt text--green me-2"></i>$123 - $456</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                <div class="d-flex mb-3">
                                    <a class="btn btn-light btn-square me-3" href=""><i class="far fa-heart text--green"></i></a>
                                    <a class="button-standard button-primary" href="">Apply Now</a>
                                </div>
                                <div class="job-discription-date">
                                    <small class="job-discription-item"><i class="far fa-calendar-alt text--green me-2"></i>Date Line: 01 Jan, 2045</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="job-item p-4 mb-4">
                        <div class="row g-4">
                            <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                <img class="flex-shrink-0 img-fluid border rounded" src="images/com-logo-5.jpg" alt="" style="width: 80px; height: 80px;">
                                <div class="text-start ps-4">
                                    <h5 class="job-title">Software Engineer</h5>
                                    <div class="job-discription">
                                        <span class="job-discription-item"><i class="fa fa-map-marker-alt text--green me-2"></i>New York, USA</span>
                                        <span class="job-discription-item"><i class="far fa-clock text--green me-2"></i>Full Time</span>
                                        <span class="job-discription-item"><i class="far fa-money-bill-alt text--green me-2"></i>$123 - $456</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                <div class="d-flex mb-3">
                                    <a class="btn btn-light btn-square me-3" href=""><i class="far fa-heart text--green"></i></a>
                                    <a class="button-standard button-primary" href="">Apply Now</a>
                                </div>
                                <div class="job-discription-date">
                                    <small class="job-discription-item"><i class="far fa-calendar-alt text--green me-2"></i>Date Line: 01 Jan, 2045</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="job-item p-4 mb-4">
                        <div class="row g-4">
                            <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                <img class="flex-shrink-0 img-fluid border rounded" src="images/com-logo-1.jpg" alt="" style="width: 80px; height: 80px;">
                                <div class="text-start ps-4">
                                    <h5 class="job-title">Software Engineer</h5>
                                    <div class="job-discription">
                                        <span class="job-discription-item"><i class="fa fa-map-marker-alt text--green me-2"></i>New York, USA</span>
                                        <span class="job-discription-item"><i class="far fa-clock text--green me-2"></i>Full Time</span>
                                        <span class="job-discription-item"><i class="far fa-money-bill-alt text--green me-2"></i>$123 - $456</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                <div class="d-flex mb-3">
                                    <a class="btn btn-light btn-square me-3" href=""><i class="far fa-heart text--green"></i></a>
                                    <a class="button-standard button-primary" href="">Apply Now</a>
                                </div>
                                <div class="job-discription-date">
                                    <small class="job-discription-item"><i class="far fa-calendar-alt text--green me-2"></i>Date Line: 01 Jan, 2045</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="button-standard button-primary py-3 px-5" href="">Browse More Jobs</a>
                </div>
                </div>
            </div>
        </div>
    </div>

<!-- Jobs End -->


<!--  --><?php
//    echo "<p>Witaj".$_SESSION['Name']."!";
//  ?>
</body>

</html>
