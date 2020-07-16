<?php
$connection = mysqli_connect('localhost', 'root', '', 'project_movie');
//initializing variables
$emailError = $emailError2 = $passwordError = $pwConfirmError = $firstnameError = $lastnameError = '';
$firstname = $lastname = $email = $pw = $pwConfirm = '';
//if boolean stays true then no errors where made
$boolean = true;

if ($connection) {
    if (isset($_POST['submit'])) {
        //checking for special chars in the inputs
        $firstname = htmlspecialchars($_POST['firstname']);
        $lastname = htmlspecialchars($_POST['lastname']);
        $email = htmlspecialchars($_POST['email']);
        $pw = htmlspecialchars($_POST['pw']);
        $pwConfirm = htmlspecialchars($_POST['pwConfirm']);
        //query to check if email was already in use
        $queryEmail = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($connection, $queryEmail);
        //validations
        if (empty($firstname)) {
            $firstnameError = '* Please write a name';
            $boolean = false;
        }
        if (empty($lastname)) {
            $lastnameError = '* Please write a name last name';
            $boolean = false;
        }
        if (empty($email)) {
            $emailError = '* Please write an email';
            $boolean = false;
        } elseif (mysqli_num_rows($result) > 0) {
            $emailError = '* Email already registered';
            $boolean = false;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError2 = '* Please write a valid email';
            $boolean = false;
        }
        if (empty($pw)) {
            $passwordError = '* Please write a password';
            $boolean = false;
        } elseif (strlen($pw) < 8) {
            $passwordError = '* Password must be at least 8 characters long';
            $boolean = false;
        }
        if ($pwConfirm !== $pw) {
            $pwConfirmError = '* Passwords must match';
            $boolean = false;
        }
        //if no errors 
        if ($boolean) {
            $hashedPassword = password_hash($pw, PASSWORD_DEFAULT);
            session_start();
            session_regenerate_id();
            $sessionID = $_COOKIE['PHPSESSID'];
            $query = "INSERT INTO users (firstname, lastname ,email, `password`, PHPSESSID) 
            VALUES ( '$firstname','$lastname', '$email','$hashedPassword','$sessionID')";
            $result = mysqli_query($connection, $query);
            $_SESSION['login'] = true;

            //go to home page after registration is succesful
            header('Location: index.php');
        }
    }
    mysqli_close($connection);
} else {
    echo 'no connection to the server';
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <form action="" method="POST">
        <input type="text" name="firstname" placeholder="first name" value="<?php echo $firstname ?>"><?php echo $firstnameError ?><br>
        <input type="text" name="lastname" placeholder="last name" value="<?php echo $lastname ?>"><?php echo $lastnameError ?><br>
        <input type=" text" name="email" placeholder="email" value="<?php echo $email ?>"><?php echo $emailError ?> <?php echo $emailError2 ?><br>
        <input type="password" name="pw" placeholder="password"><?php echo $passwordError ?><br>
        <input type="password" name="pwConfirm" placeholder="confirm password"><?php echo $pwConfirmError ?><br>
        <input type="submit" name="submit">
    </form>
</body>

</html>