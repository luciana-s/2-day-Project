<?php

/*

Joanna - Login; Nav/Search; Modify Category; Home
Luchi - Registration; Catalogue; Modify Movie; Details; Playlist

Login page
A form asks for the username (email) and password. A "Register" button is displayed, which
takes you to the registration page. A link to the forgotten password page will also be
displayed next to the login button.

*/


// best to start session at the very beginning
// calls an existing session if it exists otherwise creates one
session_start();
var_dump($_POST);
var_dump($_COOKIE);

// require_once('menu.html');

$emailError = $passwordError = '';
$filled = true;


if (isset($_POST['submitLog'])) {

    $emailIn = $_POST['email'];
    $passIn = $_POST['pass'];

    if (empty($emailIn)) {
        $emailError = 'please enter email';
        $filled = false;
    } else {
        //todo BEST PRACTICE = EMAIL :
        // first sanitise the email: filter_var($mailIn,FILTER_SANITIZE_EMAIL)
        $sanitiseMail = filter_var($emailIn, FILTER_SANITIZE_EMAIL);
        // THEN validate the email
        // Return Value: It returns the filtered data on success, or FALSE on failure.
        // https://www.geeksforgeeks.org/php-filter_var-function/
        $sanitiseMail = filter_var($sanitiseMail, FILTER_VALIDATE_EMAIL);
    }

    if (empty($passIn)) {
        $passwordError = 'please enter Password';
        $filled = false;
    }

    if ($filled) {
        // 1. Connect to the DB server
        // mysqli_connect() returns either FALSE (not connected) or info about the connection.
        $conn = mysqli_connect('localhost', 'root', '');

        // Choose which database I want to work on
        mysqli_select_db($conn, 'project_movie');

        if ($conn) {
            echo 'Connected.... verifying...<br>';

            // PREPARE my query
            $logquery = "SELECT * 
            FROM users
            WHERE email = '$sanitiseMail'
            ";

            // SEND query to the DB
            $logresults = mysqli_query($conn, $logquery);
            $userInfo = mysqli_fetch_assoc($logresults);
            $countUser = mysqli_num_rows($logresults);

            // if there is no match, row count will be zero
            if ($countUser > 0) {
                if (password_verify($passIn, $userInfo['password'])) {

                    var_dump($_SESSION);
                    var_dump($_COOKIE);

                    $_SESSION['sessUser'] = $userInfo['firstname'];
                    $_SESSION['login'] = true;
                    $_SESSION['userID'] = $userInfo['user_id'];
                    $_SESSION['email'] = $userInfo['email'];

                    echo 'Welcome back user : ' . $_SESSION['sessUser'] . '<br>';
                    var_dump($_SESSION);
                    var_dump($_COOKIE);
                } else {
                    echo 'Wrong Password';
                }
            } else {
                echo 'No username found. Pls register';
            }

            // CLOSE the resource/connection
            mysqli_close($conn);
        } else {
            echo 'Problem w cxn<br>';
        }
    }
}

if (isset($_POST['logout'])) {

    $_SESSION['login'] = false;
    echo 'Bye Bye Birdie<br>';
    var_dump($_SESSION);
    var_dump($_COOKIE);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2: Log In</title>
</head>

<body>

    <!-- Login page
    A form asks for the username (email) and password. A "Register" button is displayed, which
    takes you to the registration page. A link to the forgotten password page will also be
    displayed next to the login button. -->

    <form action="" method="post">
        <input type="email" name="email" id="">* <?= $emailError ?><br>

        <input type="password" name="pass" placeholder="Enter passWord" id="">* <?= $passwordError ?><br>
        <input type="submit" name="submitLog" value="Lhog hIn"><br><br>

        <a href="register.php"><input type="button" name="register" value="Reghister"></a><br>
        <a href="forgot-pass.php">Forgot Password? Click this link</a><br><br>

        <input type="submit" name="logout" value="Lhog hOut"><br>
    </form>

</body>

</html>