<?php
session_start();
/**
 * @param $password1
 * @param bool $flag
 * @param $password2
 * @return bool
 */
function passwords_check($password1, bool $flag, $password2): bool
{
    if (strlen($password1) < 8 || strlen($password1) > 20) {
        $flag = false;
        $_SESSION['e_password'] = "Field password must only contain from  to 20 characters";
    }

    if ($password1 != $password2) {
        $flag = false;
        $_SESSION['e_password'] = "Passwords doesn't match";
    }
    return $flag;
}

/**
 * @param $name
 * @param bool $flag
 * @param $surname
 * @return bool
 */
function name_surname_check($name, bool $flag, $surname): bool
{
    if ((strlen($name) < 3 || strlen($name) > 20)) {
        $flag = false;
        $_SESSION['e_name'] = "Field name must only contain from 3 to 20 characters";
    }

    if (!preg_match("/^[\s\p{L}]+$/u", $name)) {
        $flag = false;
        $_SESSION['e_name'] = "Field name must only contain alphanumerical characters";
    }

    if ((strlen($surname) < 3 || strlen($surname) > 20)) {
        $flag = false;
        $_SESSION['e_surname'] = "Field name must only contain from 3 to 20 characters";
    }

    if (!preg_match("/^[\s\p{L}]+$/u", $surname)) {
        $flag = false;
        $_SESSION['e_surname'] = "Field name must only contain alphanumerical characters";
    }
    return $flag;
}

/**
 * @param $email
 * @param bool $flag
 * @return bool
 */
function email_check($email, bool $flag): bool
{
    $safe_email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($safe_email, FILTER_VALIDATE_EMAIL) || ($email != $safe_email)) {
        $flag = false;
        $_SESSION['e_email'] = "Something wrong with email";
    }
    return $flag;
}

//todo: ostylować to
//todo: zabezpieczenie przed javascriptem i innymi rzeczami
//todo: crossscripting trim, ograniczona ilosc formularzy

if (isset($_POST['email'])) {
    $flag = true;

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $birthday_date = $_POST['birthday'];
    $sex = $_POST['gender'];

    $flag = name_surname_check($name, $flag, $surname);


    $email = $_POST['email'];
    $flag = email_check($email, $flag);

    $password1 = $_POST['password'];
    $password2 = $_POST['password-repeat'];

    $flag = passwords_check($password1, $flag, $password2);

    $password_hash = password_hash($password1, PASSWORD_DEFAULT);

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $connection = new mysqli($host, $db_user, $db_password, $db_name);
        if ($connection->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {

            $result = $connection->query("SELECT ProfilID FROM profil WHERE EmailAddress='$email'");

            if (!$result) {
                throw new Exception($connection->error);
            }
            $email_counter = $result->num_rows;
            if ($email_counter > 0) {
                $flag = false;
                $_SESSION['e_email'] = "User with this email already exists";
            }

            if ($flag) {
                if ($connection->query("INSERT INTO profil VALUES (NULL, '$name', '$surname', DEFAULT, DEFAULT, DEFAULT, '$password_hash', '$email',DEFAULT,'$birthday_date','$sex')")) {
                    header('Location: login_page.php');
                } else {
                    throw new Exception($connection->error);
                }
            }

            $connection->close();
        }
    } catch (Exception $exception) {
        echo "Server error";
        echo $exception;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
    <link rel="stylesheet" href="styles.css"/>
    <meta charset="UTF-8"/>
    <meta name="author" content="235967"/>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->
</head>
<body></body>
</html>

<body>
<form method="post">
    <div class="container">
        <h1>Register</h1>
        <p>Please fill in this form to take your career to the next level.</p>
        <hr/>

        <label for="name"><b>Name</b></label>
        <input
                type="text"
                placeholder="Enter Name"
                name="name"
                id="name"
                required
        />
        <?php
        if (isset($_SESSION['e_name'])) {
            echo '<div class="error">' . $_SESSION['e_name'] . '</div>';
            unset($_SESSION['e_name']);
        }
        ?>

        <label for="surname"><b>Surname</b></label>
        <input
                type="text"
                placeholder="Enter Surname"
                name="surname"
                id="surname"
                required
        />
        <?php
        if (isset($_SESSION['e_surname'])) {
            echo '<div class="error">' . $_SESSION['e_surname'] . '</div>';
            unset($_SESSION['e_surname']);
        }
        ?>

        <label for="\nemail"><b>Email</b></label>
        <input
                type="text"
                placeholder="Enter Email"
                name="email"
                id="email"
                required
        />
        <?php
        if (isset($_SESSION['e_email'])) {
            echo '<div class="error">' . $_SESSION['e_email'] . '</div>';
            unset($_SESSION['e_email']);
        }
        ?>

        <label for="password"><b>Password</b></label>
        <input
                type="password"
                placeholder="Enter Password"
                name="password"
                id="password"
                required
        />
        <?php
        if (isset($_SESSION['e_password'])) {
            echo '<div class="error">' . $_SESSION['e_password'] . '</div>';
            unset($_SESSION['e_password']);
        }
        ?>

        <label for="password-repeat"><b>Repeat Password</b></label>
        <input
                type="password"
                placeholder="Repeat Password"
                name="password-repeat"
                id="password-repeat"
                required
        />
        <label for="gender"><b>Choose gender:</b></label>
        <select name="gender" id="sex">
            <option value="Woman">Woman</option>
            <option value="Man">Man</option>
            <option value="Other">Other</option>
        </select>
        <label for="birthday"><b>Birthday:</b></label>
        <br/>
        <input type="date" id="birthday" name="birthday"/>
        <hr/>

        <button type="submit" class="registerbtn">Register</button>
    </div>

    <div class="container signin">
        <p>Already have an account? <a href="login_page.php">Sign in</a>.</p>
    </div>
</form>
</body>
