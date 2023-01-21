<?php
session_start();
if (!isset($_SESSION['Logged'])) {
    header('Location: login_page.php');
    exit();
}

if (!isset($_SESSION['switch_like']) || !isset($_SESSION['Id'])){
    header('Location: index.php');
}
include 'connect.php';

$jobid = $_SESSION['switch_like'];
$userid = $_SESSION['Id'];
$job_query = "SELECT * FROM likes WHERE `JobOfferID` LIKE ? AND `UserID` LIKE ?";
$stmt = $conn->prepare($job_query);
$stmt->bind_param("ss", $jobid,$userid);
$stmt->execute();




if ($stmt->execute()){
    header('Location: index.php');
}


