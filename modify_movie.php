<?php
$connection = mysqli_connect('localhost', 'root', '', 'project_movie');
if ($connection) {
    if (isset($_GET['id'])) {
        $urlID = $_GET['id'];
        $queryURL = "SELECT * FROM movies WHERE movie_id = $urlID";
        $resultURL = mysqli_query($connection, $queryURL);
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
    <title>Document</title>
</head>

<body>

</body>

</html>