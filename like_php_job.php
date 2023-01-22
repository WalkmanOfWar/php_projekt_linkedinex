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


$sql = "SELECT * FROM `likes` WHERE `UserID` = ? and `JobOfferID` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $userid,$jobid);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$isLiked = $row['IsLiked'];


if ($isLiked==1){
    $isLiked = 0;
}else{
    $isLiked = 1;
}
$sql = "Update likes SET `IsLiked` = ? WHERE `JobOfferID` LIKE ? AND `UserID` LIKE ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $isLiked,$jobid,$userid);
$stmt->execute();

$sql = "SELECT * FROM joboffer where `JobID` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $jobid);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

$ownerID = $row['EmployerID'];

$sql = "SELECT COUNT(*) as total FROM `likes` WHERE `OwnerID` = ? and `IsLiked` = 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $ownerID);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$total_likes = $row['total'];

$sql = "Update profil SET `ReactionsNumber` = ? WHERE `ProfilID` LIKE ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $total_likes, $ownerID);

if ($stmt->execute()){
    header('Location: index.php');
}


