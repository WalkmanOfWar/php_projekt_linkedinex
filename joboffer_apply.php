<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'classes/PHPMailer/src/Exception.php';
require 'classes/PHPMailer/src/PHPMailer.php';
require 'classes/PHPMailer/src/SMTP.php';


if (!isset($_SESSION['Logged'])) {
    header('Location: login_page.php');
    exit();
}
if (!isset($_SESSION['job_id'])){
    header('Location: index.php');
}
include "connect.php";
$flag = true;
$jobid = $_SESSION['job_id'];
$job_query = "SELECT * FROM joboffer WHERE `JobID` LIKE ?";
$stmt = $conn->prepare($job_query);
$stmt->bind_param("i", $jobid);
$stmt->execute();
$result_of_finding_job_offer = $stmt->get_result();
$row = $result_of_finding_job_offer->fetch_assoc();

$employerID = $row['EmployerID'];
$requirements = $row['Requirements'];
$position = $row['Position'];
$earnings = $row['Earnings'];
$benefits = $row['Benefits'];
$working_time = $row['WorkingTime'];
$type_of_contract = $row['TypeOfContract'];
$officeID = $row['OfficeLocationID'];

$office_query = "SELECT * FROM location WHERE `LocationID` LIKE ?";
$stmt = $conn->prepare($office_query);
$stmt->bind_param("i", $officeID);
$stmt->execute();
$result_of_finding_location = $stmt->get_result();

$row = $result_of_finding_location->fetch_assoc();

$country = $row['Country'];
$voivodeship = $row['Voivodeship'];
$city = $row['City'];
$zip = $row['ZIPCode'];
$street = $row['Street'];

$search_email_query = "SELECT * FROM profil WHERE `ProfilID` LIKE ?";
$stmt = $conn->prepare($search_email_query);
$stmt->bind_param("i", $employerID);
$stmt->execute();
$result_search_email_query = $stmt->get_result();
$row = $result_search_email_query->fetch_assoc();

$employer_email = $row['EmailAddress'];
$_SESSION['employer_email'] = $employer_email;


if(isset($_POST['button']) && isset($_FILES['resume']))
{
    $from_email = $_SESSION['email']; //from mail, sender email address
    $recipient_email = $employer_email; //recipient email address

    //Load POST data from HTML form
    //$sender_name = $_SESSION['Name']; //sender name
    $reply_to_email = $_SESSION['email']; //sender email, it will be used in "reply-to" header
    $subject   = $position; //subject for the email
    $message   = $recipient_email." have just applied for your job offer!"; //body of the email


    $path = 'resumes/' . $_FILES["resume"]["name"];
    move_uploaded_file($_FILES["resume"]["tmp_name"], $path);


    $mailto = $recipient_email;

    $content = file_get_contents($path);
    $content = chunk_split(base64_encode($content));

    // a random hash will be necessary to send mixed content
    $separator = md5(time());

    // carriage return type (RFC)
    $eol = "\r\n";

    // main header (multipart mandatory)
    $headers = "From: LinkedinexJobApp <test@test.com>" . $eol;
    $headers .= "MIME-Version: 1.0" . $eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
    $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
    $headers .= "This is a MIME encoded message." . $eol;

    // message
    $body = "--" . $separator . $eol;
    $body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
    $body .= "Content-Transfer-Encoding: 8bit" . $eol;
    $body .= $message . $eol;

    // attachment
    $body .= "--" . $separator . $eol;
    $body .= "Content-Type: application/octet-stream; name=\"" . $_FILES["resume"]["name"] . "\"" . $eol;
    $body .= "Content-Transfer-Encoding: base64" . $eol;
    $body .= "Content-Disposition: attachment" . $eol;
    $body .= $content . $eol;
    $body .= "--" . $separator . "--";

    //SEND Mail
    if (mail($mailto, $subject, $body, $headers)) {
        echo "mail send ... OK"; // or use booleans here
        header('Location: index.php');
    } else {
        echo "mail send ... ERROR!";
        print_r( error_get_last() );
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Page Title</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="main_page.css"/>
    <link rel="stylesheet" href="styles.css"/>
    <meta charset="UTF-8"/>
    <meta name="author" content="235967"/>
</head>
<body>
<div>
    <?php echo '
    <form enctype="multipart/form-data" method="POST" action="" style="min-width: 1000px;">
        <div class="container">
            <br>
            <h2>Job informations</h2>
            <hr/>
            <label for="position"><h3><b>Position:</b></h3></label>
            <h6>'.$position.'</h6>

            <label for="earnings"><h3><b>Earnings: </b></label>
            <h6>'.$earnings.'</h6>

            <label for="benefits"><h3><b>Benefits</b></h3></label>
            <h6>'.$benefits.'</h6>
            <label for="requirements"><h3><b>Requirements</b></h3></label>
            <h6>'.$requirements.'</h6>


            <label for="working-time"><h3><b>Working time: </b></h3></label>
            <h6>'.$working_time.'</h6>



            <label for="type-of-contract"><h3><b>Type of contract: </b></h3></label>
            <h6>'.$type_of_contract.'</h6>

            <br><br>
            <h2>Office address</h2>
            <hr/>
            <label for="country"><h3><b>Country: </b></h3></label>
            <h6>'.$country.'</h6>


            <label for="street"><h3><b>Street: </b></h3></label>
            <h6>'.$street.'</h6>

            <label for="city"><h3><b>City: </b></h3></label>
            <h6>'.$city.'</h6>

            <label for="voivodeship"><h3><b>State/Voivodeship: </b></h3></label>
            <h6>'.$voivodeship.'</h6>

            <label for="ZIPCode"><h3><b>ZIP Code: </b></h3></label>
            <h6>'.$zip.'</h6>
            
            <label for="voivodeship"><h3><b>Attach your resume: </b></h3></label>

            <input class="form-control" type="file" name="resume" accept=".pdf" placeholder="Attachment" required/>
        </div>
        <div class="form-group">
        ';

            echo $_SESSION['error'];

        echo '
        </div>
        <div class="form-group">
            <a href="index.php" class="btn btn-danger">Cancel</a>
            <input class="btn button-standard button-primary" type="submit" name="button" value="Submit" />
        </div>
    </form>';
    ?>
</div>
</body>
</html>