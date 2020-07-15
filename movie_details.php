<?php
$connection = mysqli_connect('localhost', 'root', '', 'project_movie');
if ($connection) {
    if (isset($_GET['id'])) {
        $urlID = $_GET['id'];
        $queryURL = "SELECT * FROM movies WHERE movie_id = $urlID";
        $resultURL = mysqli_query($connection, $queryURL);
        /* while ($bd_record = mysqli_fetch_assoc($resultURL)) {
            echo '<img src ="imgs/' . $bd_record['poster'] . '" width="300px">';
        } */
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
</head>

<body>
    <?php while ($bd_record = mysqli_fetch_assoc($resultURL)) : ?>
        <img src="imgs/<?= $bd_record['poster'] ?>" alt="">
        <h2><?= $bd_record['title'] ?></h2>
        <p><?= $bd_record['sinopsis'] ?></p>

    <?php endwhile; ?>
</body>

</html>