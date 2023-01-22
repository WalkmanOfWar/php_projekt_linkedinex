<?php
session_start();
//TODO: dokleić tego ifa tam gdzie użytkownik musi być zalogowany
if (!isset($_SESSION['Logged'])) {
    header('Location: login_page.php');
    exit();
}

include 'connect.php';
$_SESSION['error'] = '';

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
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap"
          rel="stylesheet">

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
            <a href="jobform.php">Create a job offer</a>
        </li>
        <li class="nav-item">
            <a href="profile_page.php">Profile</a>
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
            <form action="index.php" method="post">
                <input class="button--search input-mainpage" name="search" type="text" placeholder="Enter keyword">
                <button class="button--search" name="submit-search">Search</button>
            </form>
        </div>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <div class="tab-class text-center wow fadeInUp">
            <div class="tab-content">
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <?php
                    if (isset($_POST['submit-search'])) {
                        $search = mysqli_real_escape_string($conn, $_POST['search']);
                        $sql = "SELECT joboffer.JobID, joboffer.Position, joboffer.EmployerID, joboffer.WorkingTime, joboffer.Earnings, joboffer.CreationDate, location.Voivodeship, location.Country
                                                    FROM joboffer, location
                                                    WHERE joboffer.OfficeLocationID = location.LocationID 
                                                        AND joboffer.Position LIKE '%$search%'
                                                        OR location.Voivodeship LIKE '%$search%'
                                                        OR location.Country LIKE '%$search%'
                                                        ";
                    } else {
                        $sql = "SELECT joboffer.JobID, joboffer.Position,joboffer.EmployerID, joboffer.WorkingTime, joboffer.Earnings, joboffer.CreationDate, location.Voivodeship, location.Country
                                                    FROM joboffer, location
                                                    WHERE joboffer.OfficeLocationID = location.LocationID";
                    }
                    $result = mysqli_query($conn, $sql);
                    $queryResults = mysqli_num_rows($result);
                    if ($queryResults > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            $profil_query = "SELECT * FROM profil WHERE ProfilID LIKE ?";

                            $stmt = $conn->prepare($profil_query);
                            $stmt->bind_param("s", $row['EmployerID']);
                            $stmt->execute();
                            $result_of_finding_liked_post = $stmt->get_result();
                            $row_profil = $result_of_finding_liked_post->fetch_assoc();


                            echo '
                            <form method="post" action="handle_user.php">
                            <div class="job-item p-4 mb-4">
                                <div class="row g-4">
                                         <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                            <button  name= "clicked_image" class="reset-this" value= "'.$row_profil['EmailAddress'].'" type="submit"><img class="flex-shrink-0 img-fluid border rounded" src="images/'.$row_profil['ImagePath'].'" alt="" style="width: 80px; height: 80px;"></button>
                                                <div class="text-start ps-4">
                                                    <h5 class="job-title">' . $row['Position'] . '</h5>
                                                    <div class="job-discription">
                                                        <span class="job-discription-item"><i class="fa fa-map-marker-alt text--green me-2"></i>' . $row['Voivodeship'] . ', ' . $row['Country'] . '</span>
                                                        <span class="job-discription-item"><i class="far fa-clock text--green me-2"></i>' . $row['WorkingTime'] . '</span>
                                                        <span class="job-discription-item"><i class="far fa-money-bill-alt text--green me-2"></i>' . $row['Earnings'] . '</span>
                                                    </div>
                                                </div>
                                         </div>
                                     <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                        <div class="d-flex mb-3">';
                                            $is_liked = "SELECT *
                                                    FROM likes
                                                    WHERE likes.UserID = ? AND likes.JobOfferID = ?";
                                            $stmt = $conn->prepare($is_liked);
                                            $stmt->bind_param("ii", $_SESSION['Id'] , $row['JobID']);
                                            $stmt->execute();
                                            $result_of_finding_liked_post = $stmt->get_result();
                                            $row_posts = $result_of_finding_liked_post->fetch_assoc();
                                            if ($row_posts['IsLiked'] == 0){
                                                $favi = "fa-heart";
                                            }else{
                                                $favi = "fa fa-heart";
                                            }
                                            echo '
                                                <button type="submit" name=switch_like value="'.$row['JobID'].'" class="btn btn-light btn-square me-3"><i class="far '.$favi.' text--green"></i></button>';
                                            if (isset($_SESSION['rank']) && $_SESSION['rank'] =='Admin'){
                                                echo '<button type=submit name=delete_job value="'.$row['JobID'].'" class="button-standard button--color-red">Delete</button>';
                                            }
                                         echo '
                                            <button type=submit name=job_id value="'.$row['JobID'].'" class="button-standard button-primary">Apply Now</button>
                                        </div>
                                        <div class="job-discription-date">
                                            <small class="job-discription-item"><i class="far fa-calendar-alt text--green me-2"></i>Date Line: ' . $row['CreationDate'] . '</small>
                                        </div>
                                     </div>
                                </div>
                            </div>
                            </form>
                    ';
                        }
                    } else {
                        echo "there are no resources here";
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
