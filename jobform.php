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


<body>
<form method="post">
    <div class="container">
        <h1>Job offer form</h1>
        <p>Please fill in this to create job offer</p>
        <hr/>


        <label for="position"><b>Position</b></label>
        <input
                type="text"
                placeholder="Enter position"
                name="position"
                id="position"
                required
        />
        <label for="earnings"><b>Choose earnings: </b></label>
        <select name="earnings" id="earnings">
            <option value="low">3400 - 6000</option>
            <option value="medium">6000 - 12500</option>
            <option value="high">12500 - 20000</option>
            <option value="very-high">20000+</option>
        </select>

        <label for="benefits"><b>Benefits</b></label>
        <input
                type="text"
                placeholder="Enter benefits"
                name="benefits"
                id="benefits"
        />

        <label for="working-time"><b>Choose working time: </b></label>
        <select name="working-time" id="working-time">
            <option value="full-time">Full-time</option>
            <option value="part-time">Part-time</option>
        </select>

        <label for="type-of-contract"><b>Choose type of contract: </b></label>
        <select name="type-of-contract" id="type-of-contract">
            <option value="contract-of-employment">Contract of employment</option>
            <option value="contract-work">Contract work</option>
            <option value="mandate-contract">Mandate contract</option>
            <option value="b2b-contract">B2B contract</option>
            <option value="internship/practice">Internship/Practice</option>
        </select>


        <p>Office address</p>
        <hr/>


        <label for="street"><b>Street</b></label>
        <input
                type="text"
                placeholder="Enter street name"
                name="street"
                id="street"
        />
        <label for="city"><b>City</b></label>
        <input
                type="text"
                placeholder="Enter city name"
                name="city"
                id="city"
        />
        <label for="voivodeship"><b>State/Voivodeship</b></label>
        <input
                type="text"
                placeholder="Enter state or voivodeship"
                name="voivodeship"
                id="voivodeship"
        />
        <label for="ZIPCode"><b>ZIP Code</b></label>
        <input
                type="text"
                placeholder="Enter ZIP Code"
                name="ZIPCode"
                id="ZIPCode"
        />

        <button type="submit" class="registerbtn">Submit</button>
    </div>

</form>
</body>
</html>