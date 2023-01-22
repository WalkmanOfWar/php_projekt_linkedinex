<?php
session_start();
include 'connect.php';


$email = '';
//    $flag = email_check($email, $flag);

$position = '';
$earnings = '';
$benefits = '';
$working_time = '';
$type_of_contract = '';
$requirements = '';

$country = '';
$street = '';
$city = '';
$voivodeship = '';
$zip = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $flag = true;

    $email = $_SESSION['email'];

    $position = $_POST['position'];
    $earnings = $_POST['earnings'];
    $benefits = $_POST['benefits'];
    $working_time = $_POST['working-time'];
    $type_of_contract = $_POST['type-of-contract'];
    $requirements = $_POST['requirements'];

    $country = $_POST['country'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $voivodeship = $_POST['voivodeship'];
    $zip = $_POST['ZIPCode'];


    mysqli_report(MYSQLI_REPORT_STRICT);
    try {
        if ($flag) {
//            check for profilID
            $employerIDquery = "SELECT * FROM profil where EmailAddress =?";
            $stmt = $conn->prepare($employerIDquery);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if (!$result) {
                $_SESSION['error'] = '<span class="message-error">This email does not exist in database</span>';
                header('Location: jobform.php');

            }
            $row = $result->fetch_assoc();
            $employerID = $row['ProfilID'];
//            check for location

            $find_location_query = "SELECT * FROM location WHERE `Country` = ? AND `Voivodeship` = ? AND `City` = ? AND `ZIPCode` = ? AND `Street` = ?";
            $stmt = $conn->prepare($find_location_query);
            $stmt->bind_param("sssss", $country, $voivodeship, $city, $zip, $street);
            $stmt->execute();
            $result_of_finding_location = $stmt->get_result();
            if (!$result_of_finding_location) {
                $row = $result_of_finding_location->fetch_assoc();
                $locationID = $row['LocationID'];

                $insert_job_offer_query = "INSERT INTO joboffer (`JobID`, `EmployerID`, `Requirements`, `Position`, `Earnings`, `Benefits`, `TypeOfContract`, `WorkingTime`, `CreationDate`, `OfficeLocationID`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, current_timestamp(), ?)";
                $stmt = $conn->prepare($insert_job_offer_query);
                $stmt->bind_param("ssssssss", $employerID, $requirements, $position, $earnings, $benefits, $type_of_contract, $working_time, $locationID);
                if ($stmt->execute()) {
                } else {
                    throw new Exception($conn->error);
                }
            } else {
                $insert_location_query = "INSERT INTO location (`LocationID`, `Country`, `Voivodeship`, `City`, `ZIPCode`, `Street`) VALUES (NULL, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insert_location_query);
                $stmt->bind_param("sssss", $country, $voivodeship, $city, $zip, $street);
                $stmt->execute();

                $find_location_query = "SELECT *  FROM location WHERE `Country` LIKE ? AND `Voivodeship` LIKE ? AND `City` LIKE ? AND `ZIPCode` LIKE ? AND `Street` LIKE ?";
                $stmt = $conn->prepare($find_location_query);
                $stmt->bind_param("sssss", $country, $voivodeship, $city, $zip, $street);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $locationID = $row['LocationID'];


                $insert_job_offer_query = "INSERT INTO joboffer (`JobID`, `EmployerID`, `Requirements`, `Position`, `Earnings`, `Benefits`, `TypeOfContract`, `WorkingTime`, `CreationDate`, `OfficeLocationID`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, current_timestamp(), ?)";
                $stmt = $conn->prepare($insert_job_offer_query);
                $stmt->bind_param("ssssssss", $employerID, $requirements, $position, $earnings, $benefits, $type_of_contract, $working_time, $locationID);
                if ($stmt->execute()) {

                } else {
                    throw new Exception($conn->error);
                }
            }

            $get_latest_job_offer = "SELECT * FROM joboffer where `EmployerID` like ? and `Requirements` like ? and `Position` like ? and `Earnings` like ? and `Benefits` like ? and `TypeOfContract` like ? and `WorkingTime` like ? and `OfficeLocationID` like ?" ;
            $stmt1 = $conn->prepare($get_latest_job_offer);
            $stmt1->bind_param("ssssssss", $employerID, $requirements, $position, $earnings, $benefits, $type_of_contract, $working_time, $locationID);
            $stmt1->execute();
            $result = $stmt1->get_result();
            $row = $result->fetch_assoc();

            $id_of_job = $row['JobID'];
            $get_all_users = "SELECT * FROM profil";
            $result = $conn->query($get_all_users);
            if ($result->num_rows>0){
                while ($row = $result->fetch_assoc()){
                    $insert_user_to_like_table = "INSERT INTO likes (`UserID`, `JobOfferID`, `OwnerID`, `IsLiked`) VALUES (?, ?,?, DEFAULT)";
                    $stmt = $conn->prepare($insert_user_to_like_table);
                    $stmt->bind_param("iii", $row['ProfilID'] , $id_of_job,$employerID);
                    $stmt->execute();
                }
            }
            header('Location: index.php');


        }
    } catch (Exception $exception) {
        echo "Server error";
        echo $exception;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="main_page.css"/>
    <link rel="stylesheet" href="styles.css"/>
    <meta charset="UTF-8"/>
    <meta name="author" content="235967"/>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->

</head>


<body>

<form method="post" class="container-3">
    <div class="container">
        <h1>Job offer form</h1>
        <p>Please fill in this to create job offer</p>
        <hr/>



        <label for="position"><b>Position</b></label>
        <input
                type="text"
                placeholder="Enter position"
                name="position"
                id="position"
                maxlength="30"
                required
        />
        <label for="earnings"><b>Choose earnings: </b></label>
        <select name="earnings" id="earnings">
            <option value="3400 - 6000 PLN">3400 - 6000 PLN</option>
            <option value="6000 - 12500 PLN">6000 - 12500 PLN</option>
            <option value="12500 - 20000 PLN">12500 - 20000 PLN</option>
            <option value="20000+ PLN">20000+ PLN</option>
        </select>

        <label for="benefits"><b>Benefits</b></label>
        <input
                type="text"
                placeholder="Enter benefits"
                name="benefits"
                id="benefits"
                maxlength="250"
        />

        <label for="requirements"><b>Requirements</b></label>
        <input
                type="text"
                placeholder="Enter requirements"
                name="requirements"
                id="requirements"
                maxlength="250"
        />

        <label for="working-time"><b>Choose working time: </b></label>
        <select name="working-time" id="working-time">
            <option value="Full-time">Full-time</option>
            <option value="Part-time">Part-time</option>
        </select>


        <label for="type-of-contract"><b>Choose type of contract: </b></label>
        <select name="type-of-contract" id="type-of-contract">
            <option value="Contract of employment">Contract of employment</option>
            <option value="Contract work">Contract work</option>
            <option value="Mandate contract">Mandate contract</option>
            <option value="B2B contract">B2B contract</option>
            <option value="Internship/Practice">Internship/Practice</option>
        </select>


        <p>Office address</p>
        <hr/>

        <label for="country"><b>Country</b></label>
        <input
                type="text"
                placeholder="Enter country name"
                name="country"
                id="country"
                maxlength="30"
        />

        <label for="street"><b>Street</b></label>
        <input
                type="text"
                placeholder="Enter street name"
                name="street"
                id="street"
                maxlength="30"
        />
        <label for="city"><b>City</b></label>
        <input
                type="text"
                placeholder="Enter city name"
                name="city"
                id="city"
                maxlength="30"
        />
        <label for="voivodeship"><b>State/Voivodeship</b></label>
        <input
                type="text"
                placeholder="Enter state or voivodeship"
                name="voivodeship"
                id="voivodeship"
                maxlength="30"
        />
        <label for="ZIPCode"><b>ZIP Code</b></label>
        <input
                type="text"
                placeholder="Enter ZIP Code"
                name="ZIPCode"
                id="ZIPCode"
                maxlength="30"
        />

        <?php
        if (isset($_SESSION['error'])) {
            echo $_SESSION['error'];

        }
        ?>
        <button type="submit" class="registerbtn">Submit</button>
        <a href="index.php" class="button--color-red">Cancel</a>

    </div>
</form>
</body>
</html>