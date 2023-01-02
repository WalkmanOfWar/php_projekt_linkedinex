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
<!--navbar-->
  <navbar>
      <ul class="nav-list">
          <li class="nav-item">
              <a href="#"><img class="logo" src="images/logo-no-background.png"></a>
          </li>
          <li class="nav-item">
              <a href="#">Search</a>
          </li>
          <li class="nav-item">
              <a href="#">Profile</a>
          </li>
          <li class="nav-item">
              <a href="logout.php">Logout</a>
          </li>
      </ul>
  </navbar>
<!--  searchbox -->
  <div class="container">
      <div class="row">
          <div class="search-left">
              <input class="button--search" type="text" placeholder="Enter keyword">
              <button class="button--search">Search</button>
          </div>
      </div>
  </div>
<!--  jobs-->
    <div class="container-xxl">
        <div class="container">
            <div class="tab-content">
                <div id="tab-1" class="tab-pane">
                    <div class="job-item">
                        <div class="row" >
                            <div class="job-left">
                                <img src="images/com-logo-1.jpg" alt="" style="width: 80px; height: 80px;">
                                <div class="text-start">
                                    <h5>Java Developer</h5>
                                    <span class="text-truncate">
                                        <i class="fa fa-map-marker-alt text-primary me-2"></i>
                                        "New York,Usa"
                                    </span>
                                    <span class="text-truncate">
                                        <i class="fa fa-map-marker-alt text-primary me-2"></i>
                                        "New York,Usa"
                                    </span>
                                    <span class="text-truncate">
                                        <i class="fa fa-map-marker-alt text-primary me-2"></i>
                                        "New York,Usa"
                                    </span>
                                </div>
                            </div>
                            <div class="job-right">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!--  --><?php
//    echo "<p>Witaj".$_SESSION['Name']."!";
//  ?>
</body>

<footer>
    <p>Author: Maciej Sierzputowski</p>
    <p><a href="mailto:235967@edu.p.lodz.pl">235967@edu.p.lodz.pl</a></p>
</footer>