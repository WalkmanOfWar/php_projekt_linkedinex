<?php
session_start();
//TODO: dokleić tego ifa tam gdzie użytkownik musi być zalogowany
if(!isset($_SESSION['Logged'])){
    header('Location: login_page.php');
    exit();
}
?>