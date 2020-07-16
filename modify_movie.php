<?php
require_once 'nav.php';
$connection = mysqli_connect('localhost', 'root', '', 'project_movie');
if ($connection) {
    if (isset($_GET['id'])) {
        $urlID = $_GET['id'];
        $queryURL = "SELECT * FROM movies WHERE movie_id = $urlID";
        $resultURL = mysqli_query($connection, $queryURL);
        $db_record = mysqli_fetch_assoc($resultURL);
    } else {
        header('Location: http://localhost/Project/2-day-Project/catalogue.php');
    }
} else {
    echo 'no connection to the server';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify movie</title>
</head>

<body>
    <form action="">
        <input type="number" name="id" value="<?php $db_record['movie_id']; ?>"><br>
        <input type="text" name="" value="<?php $db_record['title']; ?>"><br>
        <input type="date" name="" value="<?php $db_record['year_of_release']; ?>"><br>
        <input type="text" name="" value="<?php $db_record['poster']; ?>"><br>
        <input type="text" name="" value="<?php $db_record['path']; ?>"><br>
        <input type="textarea" name="" value="<?php $db_record['sinopsis']; ?>"><br>
    </form>
</body>

</html>