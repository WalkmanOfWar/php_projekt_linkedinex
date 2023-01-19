<?php
session_start();
//TODO: dokleić tego ifa tam gdzie użytkownik musi być zalogowany
if (!isset($_SESSION['Logged']) || !isset($_SESSION['email'])) {
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
<navbar>
    <ul class="nav-list">
        <li class="nav-item">
            <a href="#"><img class="logo" src="images/logo-no-background.png" alt=""></a>
        </li>
        <li class="nav-item">
            <a href="index.php">Search</a>
        </li>
        <li class="nav-item">
            <a href="#">Profile</a>
        </li>
        <li class="nav-item">
            <a href="logout.php">Logout</a>
        </li>
    </ul>
</navbar>
<?php
include 'connect.php';

$email = "235967@edu.p.lodz.pl";

$employerIDquery = "SELECT * FROM profil where EmailAddress =?";
$stmt = $conn->prepare($employerIDquery);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$name = $row['Name'];
$surname = $row['Surname'];
$info = $row['InformationsAboutYou'];
$adressID = $row['AddressID'];
$sex = $row['Sex'];

/**
 * @param $sex
 * @return string
 */
function selectPicture($sex): string
{
    if ($sex == "Man") {
        $src = "https://bootdey.com/img/Content/avatar/avatar7.png";
    } else if ($sex == "Woman") {
        $src = "https://bootdey.com/img/Content/avatar/avatar8.png";
    } else {
        $src = "https://bootdey.com/img/Content/avatar/avatar2.png";
    }
    return $src;
}

$src = selectPicture($sex);


$find_location_query = "SELECT * FROM location WHERE `LocationID` LIKE ?";
$stmt = $conn->prepare($find_location_query);
$stmt->bind_param("s", $adressID);
$stmt->execute();
$result_of_finding_location = $stmt->get_result();
$row = $result_of_finding_location->fetch_assoc();

$_SESSION['adressID'] = $adressID;
$street = $row['Street'];
$voivodeship = $row['Voivodeship'];
$city = $row['City'];
$zip =$row['ZIPCode'];
$country = $row['Country'];
echo '

<div class="profile-body">
    <div class="container">
        <div class="row gutters">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="account-settings">
                            <div class="user-profile">
                                <div class="user-avatar">
                                    <img src='.$src.'>
                                </div>
                                <h5 class="user-name">'.$name.' '.$surname.'</h5>
                                <h6 class="user-email">'.$email.'</h6>
                            </div>
                            <div class="about">
                                <h5>Informations about me</h5>
                                <p>'.$info.'</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 text-primary text--green">Personal Details</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <h6>'.$name.'</h6>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="surname">Surname</label>
                                    <h6>'.$surname.'</h6>
                                </div>
                            </div>

                        </div>
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mt-3 mb-2 text-primary text--green">Address</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="Street">Street</label>
                                    <h6>'.$street.'</h6>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="ciTy">City</label>
                                    <h6>'.$city.'</h6>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="sTate">State/Voivodeship</label>
                                    <h6>'.$voivodeship.'</h6>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="zIp">Zip Code</label>
                                    <h6>'.$zip.'</h6>
                                </div>
                            </div>
                        </div>
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-right">
                                    <button type="button" id="submit" name="submit" class="btn button-update">
                                        <a href="profile_page_update.php">Edit your settings</a>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>'

?>

</body>

</html>
