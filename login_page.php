<?php
    session_start();
    if((isset($_SESSION['Logged']))&&($_SESSION['Logged']==true)){
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
            <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Email" name="login" required/>


            <label for="psw"><b>Password</b></label>
            <input
                    type="password"
                    placeholder="Enter Password"
                    name="password"
                    required
            />


            <button type="submit">Login</button>
            <?php
            if(isset($_SESSION['error'])){
                echo $_SESSION['error'];
            }
            ?>
        </div>

        <div class="container" style="background-color: #f1f1f1">
            <a href="register.php" class="button--color-red">Register now</a>
            <span class="psw">Forgot <a href="#">password?</a></span>
        </div>
    </form>
</div>


</body>

<footer>
    <p>Author: Maciej Sierzputowski</p>
    <p><a href="mailto:235967@edu.p.lodz.pl">235967@edu.p.lodz.pl</a></p>
</footer>
</html>
