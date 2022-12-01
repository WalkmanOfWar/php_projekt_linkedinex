<?php
session_start();
if (!(isset($_POST['login']))&&(!isset($_POST['password']))){
    header('Location: login_page.php');
}
require_once "connect.php";

$connection = new mysqli($host, $db_user, $db_password, $db_name);

if ($connection->connect_errno!=0){
    echo "Error".$connection->connect_errno."Opis".$connection->connect_error;
}else{
    $login = $_POST['login'];
    $password=$_POST['password'];
    //Zawsze przed możliwym polem do wpisania dla człowieka użyć tego
    $login = htmlentities($login,ENT_QUOTES,"UTF-8");
    $password = htmlentities($password,ENT_QUOTES,"UTF-8");

    $sql = sprintf("SELECT * FROM profil WHERE Login = '%s' AND Password = '%s'",
            mysqli_escape_string($connection,$login),
            mysqli_escape_string($connection,$password)
            );
    //////////////////////////////////////////////////////////////////
    if($result = @$connection->query($sql)){
        $user_number = $result->num_rows;
        if ($user_number>0){
            $row =  $result->fetch_assoc();

            $_SESSION['Name'] = $row['Name'];
            $_SESSION['Logged'] = true;
            $_SESSION['Id'] = $row['Login'];
            $result->free_result();
            unset($_SESSION['Error']);
            header('Location: index.php');

        }else{
            $_SESSION['error'] = '<span class="message-error">Incorrect login or password</span>';
            header('Location: login_page.php');
        }
    }
    $connection->close();
}

