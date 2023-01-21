<?php
session_start();


if (isset($_POST['delete_job'])){
    $_SESSION['delete_job'] = $_POST['delete_job'];
    header('Location: delete_job.php');
}else
if (isset($_POST['job_id'])){
    $_SESSION['job_id'] = $_POST['job_id'];
    header('Location: joboffer_apply.php');
}
if (isset($_POST['delete_profile'])){
    $_SESSION['delete_profile'] = $_POST['delete_profile'];
    header('Location: delete_profile.php');
}
if (isset($_POST['switch_like'])){
    $_SESSION['switch_like'] = $_POST['switch_like'];
    header('Location: like_php_job.php');
}