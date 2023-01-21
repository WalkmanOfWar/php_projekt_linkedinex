<?php
session_start();
if (!isset($_SESSION['Logged'])) {
    header('Location: login_page.php');
    exit();
}

if (!isset($_SESSION['delete_job'])){
    header('Location: index.php');
}
include 'connect.php';

$jobid = $_SESSION['delete_job'];
$job_query = "DELETE FROM joboffer WHERE `JobID` LIKE ?";
$stmt = $conn->prepare($job_query);
$stmt->bind_param("s", $jobid);
$stmt->execute();

$likes_query = "DELETE FROM likes WHERE `JobOfferID` LIKE ?";
$stmt = $conn->prepare($likes_query);
$stmt->bind_param("s", $jobid);


if ($stmt->execute()){
    header('Location: index.php');
}


