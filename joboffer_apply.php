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
    $message   = "I have just applied for your job offer!"; //body of the email


    $path = 'resumes/' . $_FILES["resume"]["name"];
    move_uploaded_file($_FILES["resume"]["tmp_name"], $path);

    $mail = new PHPMailer;
    $mail->IsSMTP();        //Sets Mailer to send message using SMTP
    $mail->Host = 'smtp.poczta.onet.pl';  //Sets the SMTP hosts of your Email hosting, this for Godaddy
    $mail->Port = '465';        //Sets the default SMTP server port
    $mail->SMTPAuth = true;       //Sets SMTP authentication. Utilizes the Username and Password variables
    $mail->Username = 'javatest1234@op.pl';     //Sets SMTP username
    $mail->Password = 'Maciek.sierzputowski37';     //Sets SMTP password
    $mail->SMTPSecure = 'ssl';       //Sets connection prefix. Options are "", "ssl" or "tls"
    $mail->From = $from_email;     //Sets the From email address for the message
    $mail->FromName = '';    //Sets the From name of the message
    try {
        $mail->AddAddress('maciek.sierzputowski37@gmail.com', 'Macko');
    } catch (Exception $e) {
        $error = 'address bad';
        var_dump($e);
    }
    try {
        $mail->AddAttachment($path);
    } catch (Exception $e) {
        $error = 'attachment failed';
        var_dump($e);

    }     //Adds an attachment from a path on the filesystem
    $mail->Subject = 'Application for job';    //Sets the Subject of the message
    $mail->Body = $message;       //An HTML or plain text message body
    try {
        if ($mail->Send())        //Send an Email. Return true on success or false on error
        {
            $error = '<div class="alert alert-success">Application Successfully Submitted</div>';
            unlink($path);
        } else {
            $error = '<div class="alert alert-danger">There is an Error</div>';
        }
    } catch (Exception $e) {
        var_dump($e);
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
            <h1></h1>
             <a href="profile_page.php">Employer profile</a>
            <label for="position"><b>Position:</b></label>
            <h6>'.$position.'</h6>

            <label for="earnings"><b>Earnings: </b></label>
            <h6>'.$earnings.'</h6>

            <label for="benefits"><b>Benefits</b></label>
            <h6>'.$benefits.'</h6>
            <label for="requirements"><b>Requirements</b></label>
            <h6>'.$requirements.'</h6>


            <label for="working-time"><b>Working time: </b></label>
            <h6>'.$working_time.'</h6>



            <label for="type-of-contract"><b>Type of contract: </b></label>
            <h6>'.$type_of_contract.'</h6>


            <p>Office address</p>
            <hr/>
            <label for="country"><b>Country: </b></label>
            <h6>'.$country.'</h6>


            <label for="street"><b>Street: </b></label>
            <h6>'.$street.'</h6>

            <label for="city"><b>City: </b></label>
            <h6>'.$city.'</h6>

            <label for="voivodeship"><b>State/Voivodeship: </b></label>
            <h6>'.$voivodeship.'</h6>

            <label for="ZIPCode"><b>ZIP Code: </b></label>
            <h6>'.$zip.'</h6>
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