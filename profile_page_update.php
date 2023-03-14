<?php
session_start();
if (!isset($_SESSION['Logged'])) {
    header('Location: login_page.php');
    exit();
}
include "connect.php";



$name = '';
$surname = '';
$info = '';
$street = '';
$city = '';
$voivodeship = '';
$zip = '';
$locationID = '';


$email = $_SESSION['email'];

$employerIDquery = "SELECT * FROM profil where EmailAddress =?";
$stmt = $conn->prepare($employerIDquery);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$namePrev = $row['Name'];
$surnamePrev = $row['Surname'];
$infoPrev = $row['InformationsAboutYou'];
$sex = $row['Sex'];
$src = $row['ImagePath'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $email_query = "SELECT * FROM `profil` WHERE `EmailAddress` LIKE ?";
    $stmt = $conn->prepare($email_query);
    $stmt->bind_param("s", $_SESSION['email']);
    $stmt->execute();
    $result_of_finding_email = $stmt->get_result();
    $row = $result_of_finding_email->fetch_assoc();

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $info = $_POST['informations'];


    $street = $_POST['street'];
    $city = $_POST['city'];
    $voivodeship = $_POST['voivodeship'];
    $zip = $_POST['ZIPCode'];
    $country = $_POST['country'];

    if ($_FILES['image'] != null){
        $path = 'images/' . $_FILES["image"]["name"];
        move_uploaded_file($_FILES["image"]["tmp_name"], $path);
        $src = $_FILES['image']['name'];
    }



    $sql = "SELECT `ProfilID` FROM `profil` WHERE `EmailAddress` LIKE ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt){
        trigger_error($conn->error, E_USER_ERROR);
    }
    $stmt->bind_param("s", $_SESSION['email']);
    $stmt->execute();
    $result_of_ProfilID = $stmt->get_result();
    $row = $result_of_ProfilID->fetch_assoc();
    $profilID = $row['ProfilID'];



    $find_location_query = "SELECT * FROM location WHERE `Country` = ? AND `Voivodeship` = ?  AND `City` = ? AND `ZIPCode` = ? AND `Street` = ?";
    $stmt = $conn->prepare($find_location_query);
    $stmt->bind_param("sssss", $country,$voivodeship,$city,$zip,$street);
    $stmt->execute();
    $result_of_finding_location = $stmt->get_result();
    $row = $result_of_finding_location->fetch_assoc();

    if (!$row) {
        $insert_location_query = "INSERT INTO location (`LocationID`, `Voivodeship`, `City`, `ZIPCode`, `Street`, `Country`) VALUES (NULL, ?, ?, ?, ?,?)";
        $stmt = $conn->prepare($insert_location_query);
        $stmt->bind_param("sssss", $voivodeship, $city, $zip, $street, $country);
        $stmt->execute();
        $find_location_query = "SELECT *  FROM location WHERE `Voivodeship` LIKE ? AND `City` LIKE ? AND `ZIPCode` LIKE ? AND `Street` LIKE ?";
        $stmt = $conn->prepare($find_location_query);
        $stmt->bind_param("ssss",$voivodeship,$city,$zip,$street);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $locationID = $row['LocationID'];
    }else{
        $locationID = $row['LocationID'];
    }

    $sql = "Update `profil` SET `Name` = ?, `Surname` = ?, `EmailAddress` = ? WHERE `ProfilID` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $surname, $email,  $profilID);
    $stmt->execute();
    $sql = "Update `profil` SET `InformationsAboutYou` = ?,`AddressID`=?,`ImagePath`=? WHERE `ProfilID` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $info,$locationID,$src, $profilID);

    if($stmt->execute()){
        $_SESSION['email'] = $email;
        header('Location: profile_page.php');
    }

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
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap"
          rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

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
<form enctype="multipart/form-data" method="post">
    <div class="profile-body">
        <div class="container">
            <div class="row gutters">
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="account-settings">
                                <?php
                                echo '
                                
                                <div class="user-profile">
                                <div class="user-avatar">
                                    <img src="/images/'.$src.'">
                                </div>
                                <h5 class="user-name">' . $namePrev . ' ' . $surnamePrev . '</h5>
                                <h6 class="user-email">' . $_SESSION['email'] . '</h6>
                            </div>
                            <div class="about">
                                <h5>Informations about me</h5>
                                <p>' . $infoPrev . '</p>
                            </div>'
                                ?>
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
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter name"
                                               required
                                                >
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="surname">Surname</label>
                                        <input type="text" name="surname" class="form-control" id="surname"
                                               placeholder="Enter surname"
                                               required
                                        >
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                               placeholder="Enter email address" required>
                                    </div>

                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="informations">Informations about you</label>
                                        <input type="text" name="informations" class="form-control" id="informations"
                                               placeholder="Tell us something about you" required>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="image">Select new profile picture</label>
                                        <input class="form-control" type="file" name="image" placeholder="image"/>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" name="country" class="form-control" id="country"
                                               placeholder="Enter in which country you are avaiable" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h6 class="mt-3 mb-2 text-primary text--green">Address</h6>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="street">Street</label>
                                        <input type="text" name="street" class="form-control" id="street" placeholder="Enter Street"
                                               required>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" name="city" class="form-control" id="city" placeholder="Enter City"
                                               required>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="voivodeship">State/Voivodeship</label>
                                        <input type="text" name="voivodeship" class="form-control" id="voivodeship"
                                               placeholder="Enter State" required>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="ZIPCode">Zip Code</label>
                                        <input type="text" name="ZIPCode" class="form-control" id="ZIPCode" placeholder="Zip Code"
                                               required>
                                    </div>
                                </div>
                            </div>
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="text-right">
                                        <a href="profile_page.php" class="btn btn-danger">Cancel</a>
                                        <button type="submit" id="submit" name="submit" class="btn button-update">
                                            Update
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

</body>

</html>