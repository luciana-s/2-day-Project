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

require_once('menu.html');

$firstnameError = $lastnameError = $passwordError = '';
$filled = true;


if (isset($_POST['submitLog'])) {

    $firstIn = $_POST['firstname'];
    $lastIn = $_POST['lastname'];
    // hash the password before saving in database using 'password_hash()'. 
    $passIn = $_POST['pass'];

    if (empty($firstIn)) {
        $firstnameError = 'please enter First name';
        $filled = false;
    }

    if (empty($lastIn)) {
        $lastnameError = 'please enter Last name';
        $filled = false;
    }

    if (empty($passIn)) {
        $passwordError = 'please enter Password';
        $filled = false;
    } else {
        # code...
    }

    if ($filled) {
        // 1. Connect to the DB server
        // mysqli_connect() returns either FALSE (not connected) or info about the connection.
        $conn = mysqli_connect('localhost', 'root', '');

        // Choose which database I want to work on
        mysqli_select_db($conn, 'spotifydb');

        if ($conn) {
            echo 'Connected.... verifying...<br>';

            // PREPARE my query
            $logquery = 'SELECT * 
            FROM users
            WHERE first_name = "' . $firstIn . '" AND last_name = "' . $lastIn . '"
            ';

            // SEND query to the DB
            $logresults = mysqli_query($conn, $logquery);
            $userInfo = mysqli_fetch_assoc($logresults);
            $countUser = mysqli_num_rows($logresults);

            // if there is no match, row count will be zero
            if ($countUser > 0) {
                if (password_verify($passIn, $userInfo['password'])) {

                    /* if (!empty($userInfo['PHPSESSID'])) {
                        // if it is available, assign the sessID unique to the user that is saved on the DB 
                        // to the local cookie sessID
                        $_COOKIE['PHPSESSID'] = $userInfo['PHPSESSID'];
                    } */

                    var_dump($_SESSION);
                    var_dump($_COOKIE);

                    $_SESSION['sessUser'] = $userInfo['first_name'];
                    $_SESSION['login'] = true;
                    $_SESSION['userID'] = $userInfo['user_id'];
                    $_SESSION['mail'] = $userInfo['mail'];

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
        <input type="email" name="email" id="">

        <input type="password" name="pass" placeholder="Enter passWord" id="">* <?= $passwordError ?><br>
        <input type="submit" name="submitLog" value="Lhog hIn"><br><br>

        <a href="register.php"><input type="button" name="register" value="Reghister"></a><br>
        <a href="forgot-pass.php">Forgot Password? Click this link</a><br><br>

        <input type="submit" name="logout" value="Lhog hOut"><br>
    </form>

</body>

</html>