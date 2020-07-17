<?php

/*
    show one playlist, with user it belongs to,
    can edit and delete playlist, can delete items from playlist
*/
session_start();

$delMDone = '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit playlist</title>
</head>

<body>
    <?php
    require_once('nav.php');
    ?>

    <?php
    // 1. Connect to the DB server
    // mysqli_connect() returns either FALSE (not connected) or info about the connection.
    $conn = mysqli_connect('localhost', 'root', '', 'project_movie');

    if ($_SESSION['login']) {

        if (isset($_GET['playlist_id']) && isset($_GET['movie_id'])) {
            // Grabbing what's in the URL
            // then CAST to INTEGER (otherwise POST and GET returns values as strings)
            $playlistid = (int) $_GET['playlist_id'];
            $movieid = (int) $_GET['movie_id'];

            if ($playlistid > 0) {

                // Get playlist
                // PREPARE my query
                $query = "SELECT p.*, c.movie_id, m.title
                FROM playlist p
                INNER JOIN playlist_content c
                ON p.playlist_id = c.playlist_id
                INNER JOIN movies m
                ON c.movie_id = m.movie_id
                WHERE c.playlist_id = $playlistid AND c.movie_id = $movieid
                ";

                // SEND query to the DB
                $results = mysqli_query($conn, $query);

                $movies = mysqli_fetch_all($results, MYSQLI_ASSOC);
            } else {
                echo 'Problem w Description page cxn<br>';
            }
        }
    } else {
        echo 'Problem w Description page cxn<br>';
    }


    // Click on the DELETE btn, delete permanently the selected movie title 
    if (isset($_POST['delMovie'])) {
        // 1. Connect to the DB server
        $conn = mysqli_connect('localhost', 'root', '');
        // 2. Choose which database I want to work on
        mysqli_select_db($conn, 'project_movie');

        //? getting the category details
        // PREPARE my query
        $delMquery = "DELETE 
        FROM playlist_content 
        WHERE playlist_id = $playlistid AND movie_id = $movieid
        ";
        // SEND query to the DB
        $delMresult = mysqli_query($conn, $delMquery);
        // success message to print
        $delMDone = 'This movie has been deleted from this playlist.';
        // 3. CLOSE the resource/connection
        mysqli_close($conn);

        // redirect to full playlist
        header("Location: playlist.php?playlist_id=" . $playlistid);
    }

    ?>

    <!-- printing the playlist title and movie to delete -->
    <?php foreach ($movies as $movie) : ?>
        <form action="" method="post">
            <div>Playlist : <strong><?= $movie['name'] ?></strong></div>
            <div>Movie : <strong><?= $movie['title'] ?></strong></div>
            <input type="submit" name="delMovie" value="Permanently Delete this movie from Playlist">
        </form>

        <span><?= $delMDone ?></span>
    <?php endforeach; ?>

</body>

</html>