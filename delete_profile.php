<?php
session_start();
if (!isset($_SESSION['Logged'])) {
    header('Location: login_page.php');
    exit();
}

if (!isset($_SESSION['delete_profile'])){
    header('Location: index.php');
}
include 'connect.php';

$profileid = $_SESSION['delete_profile'];


$job_query = "DELETE FROM joboffer WHERE `EmployerID` LIKE ?";
$stmt = $conn->prepare($job_query);
$stmt->bind_param("s", $profileid);
$stmt->execute();

$likes_query = "DELETE FROM likes WHERE `UserID` LIKE ?";
$stmt = $conn->prepare($likes_query);
$stmt->bind_param("s", $profileid);
$stmt->execute();

$profile_query = "DELETE FROM `profil` WHERE `ProfilID` LIKE ?";
$stmt = $conn->prepare($profile_query);
$stmt->bind_param("s", $profileid);
if ($stmt->execute()){
    header('Location: index.php');
}
