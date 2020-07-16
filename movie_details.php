<?php
require_once 'nav.php';
$connection = mysqli_connect('localhost', 'root', '', 'project_movie');
if ($connection) {
    if (isset($_GET['id'])) {
        $urlID = $_GET['id'];
        $queryURL = "SELECT * FROM movies WHERE movie_id = $urlID";
        $resultURL = mysqli_query($connection, $queryURL);
    } else {
        header('Location: http://localhost/Project/2-day-Project/catalogue.php');
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
    <?php while ($db_record = mysqli_fetch_assoc($resultURL)) : ?>
        <img src="imgs/<?= $db_record['poster'] ?>" alt="">
        <h2><?= $db_record['title'] ?></h2>
        <p><?= $db_record['sinopsis'] ?></p>
        <p>Release date: <?= $db_record['year_of_release'] ?></p>
        <a href="http://localhost/Project/2-day-Project/modify_movie.php?id= <?php echo $urlID ?>">Modify</a>
    <?php endwhile; ?>
</body>

</html>