<?php
    session_start();
    //TODO: dokleić tego ifa tam gdzie użytkownik musi być zalogowany
    if(!isset($_SESSION['Logged'])){
        header('Location: login_page.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en_US">
  <head>
    <title>Page Title</title>
    <link rel="stylesheet" href="main_page.css" />
    <link rel="stylesheet" href="bootsstrapstylesheet" />
    <meta charset="UTF-8" />
    <meta name="author" content="235967" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->
  </head>
  <body></body>
</html>

<body>
  <div class="navigation-bar">
      <img class="img-logo" src="images/logo-no-background.png" /><img />
      <ul>
        <li class="dropdown">
          <a href="javascript:void(0)" class="dropbtn">Settings</a>
          <div class="dropdown-content">
            <a href="logout.php">Logout</a>
            <a href="#">Link 2</a>
            <a href="#">Link 3</a>
          </div>
        </li>
        <li><a href="about.html">About</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="index.php">Home</a></li>
      </ul>
  </div>
  <?php
    echo "<p>Witaj".$_SESSION['Name']."!";
  ?>
</body>

<footer>
    <p>Author: Maciej Sierzputowski</p>
    <p><a href="mailto:235967@edu.p.lodz.pl">235967@edu.p.lodz.pl</a></p>
</footer>