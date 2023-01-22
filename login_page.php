<?php
    session_start();
    if((isset($_SESSION['Logged']))&& $_SESSION['Logged']){
        header('Location: index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Page Title</title>
    <link rel="stylesheet" href="styles.css"/>
    <meta charset="UTF-8"/>
    <meta name="author" content="235967"/>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->
</head>
<body>
<div class="logincontainer">
    <form action="login.php" method="post">
        <div class="imgcontainer">
            <img src="images/logo-color-fixed.png" alt="Avatar" class="avatar"/>
        </div>

        <div class="container">
            <label for="uname"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" maxlength="30" name="login" required/>



            <label for="psw"><b>Password</b></label>
            <input
                    type="password"
                    placeholder="Enter Password"
                    name="password"
                    maxlength="30"
                    required
            />


            <button type="submit">Login</button>
            <?php
            if(isset($_SESSION['error'])){
                echo $_SESSION['error'];
            }
            ?>
        </div>

        <div class="container">
            <span class="psw">Forgot <a href="#">password?</a></span>
        </div>

        <div class="container">
            <a href="register.php" class="button--color-red">Register now</a>
        </div>
    </form>
</div>


</body>
</html>
