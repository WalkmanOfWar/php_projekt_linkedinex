<?php
session_start();
if (!(isset($_POST['login']))&&(!isset($_POST['password']))){
    header('Location: login_page.php');
}
require_once "connect.php";

try {
    $connection = new mysqli($host, $db_user, $db_password, $db_name);
    if ($connection->connect_errno!=0){
        throw new Exception(mysqli_connect_errno());
    }else{
        $login = $_POST['login'];
        $password=$_POST['password'];
        //Zawsze przed możliwym polem do wpisania dla człowieka użyć tego
        $login = htmlentities($login,ENT_QUOTES,"UTF-8");
        //todo: zrobic inne zabezpieczenia
        $sql = sprintf("SELECT * FROM profil WHERE EmailAddress = '%s'",
            mysqli_escape_string($connection,$login));
        //////////////////////////////////////////////////////////////////
        if($result = @$connection->query($sql)){
            $user_number = $result->num_rows;
            if ($user_number>0){
                $row =  $result->fetch_assoc();
                if (password_verify($password,$row['Password'])){
                    $_SESSION['Name'] = $row['Name'];
                    $_SESSION['Logged'] = true;
                    $_SESSION['Id'] = $row['Login'];
                    $result->free_result();
                    unset($_SESSION['Error']);
                    header('Location: index.php');
                }else{
                    $_SESSION['error'] = '<span class="message-error">Incorrect password</span>';
                    header('Location: login_page.php');
                }
            }else{
                $_SESSION['error'] = '<span class="message-error">Incorrect login or password</span>';
                header('Location: login_page.php');
            }
        }
        $connection->close();
    }
}catch (Exception $exception){
    echo "Server error";
    echo $exception;
}



if ($connection->connect_errno!=0){
    echo "Error".$connection->connect_errno."Opis".$connection->connect_error;
}else{
    $login = $_POST['login'];
    $password=$_POST['password'];
    //Zawsze przed możliwym polem do wpisania dla człowieka użyć tego
    $login = htmlentities($login,ENT_QUOTES,"UTF-8");
    //todo: zrobic inne zabezpieczenia
    $sql = sprintf("SELECT * FROM profil WHERE EmailAddress = '%s'",
            mysqli_escape_string($connection,$login));
    //////////////////////////////////////////////////////////////////
    if($result = @$connection->query($sql)){
        $user_number = $result->num_rows;
        if ($user_number>0){
            $row =  $result->fetch_assoc();
            if (password_verify($password,$row['Password'])){
                $_SESSION['Name'] = $row['Name'];
                $_SESSION['Logged'] = true;
                $_SESSION['Id'] = $row['Login'];
                $result->free_result();
                unset($_SESSION['Error']);
                header('Location: index.php');
            }else{
                $_SESSION['error'] = '<span class="message-error">Incorrect password</span>';
                header('Location: login_page.php');
            }
        }else{
            $_SESSION['error'] = '<span class="message-error">Incorrect login or password</span>';
            header('Location: login_page.php');
        }
    }
    $connection->close();
}

