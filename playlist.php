<?php

/*
    show one playlist, with user it belongs to,
    can edit and delete playlist, can delete items from playlist
*/
session_start();

$modDone = $delDone = '';

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

        if (isset($_GET['playlist_id'])) {

            // Grabbing what's in the URL
            // then CAST to INTEGER (otherwise POST and GET returns values as strings)
            $playlistid = (int) $_GET['playlist_id'];

            if ($playlistid > 0) {

                // 1. Connect to the DB server
                $conn = mysqli_connect('localhost', 'root', '', 'project_movie');

                // Get playlist title
                // PREPARE my query
                $queryUserPL = "SELECT p.* 
                FROM playlist p 
                WHERE p.playlist_id = $playlistid 
                ";

                // SEND query to the DB
                $resultsUserPL = mysqli_query($conn, $queryUserPL);

                $userPL = mysqli_fetch_all($resultsUserPL, MYSQLI_ASSOC);

                // Get playlist
                // PREPARE my query
                $query = "SELECT p.*, c.movie_id, m.title
                FROM playlist p
                INNER JOIN playlist_content c
                ON p.playlist_id = c.playlist_id
                INNER JOIN movies m
                ON c.movie_id = m.movie_id
                WHERE p.playlist_id = $playlistid
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

    // Click on the edit btn, modify the selected playlist title
    if (isset($_POST['subModPL'])) {
        // 1. Connect to the DB server
        $conn = mysqli_connect('localhost', 'root', '');
        // 2. Choose which database I want to work on
        mysqli_select_db($conn, 'project_movie');

        //? getting the category details
        // PREPARE my query
        $plEquery = "SELECT p.* 
        FROM playlist p 
        WHERE p.playlist_id = $playlistid
        ";
        // SEND query to the DB
        $plEresult = mysqli_query($conn, $plEquery);
        // get all movies queried
        $editPL = mysqli_fetch_assoc($plEresult);

        // save for later use
        $_SESSION['playlist_title'] = $editPL['name'];

        // 3. CLOSE the resource/connection
        mysqli_close($conn);
    }

    // MODIFYING the category name
    if (isset($_POST['subModDone'])) {
        // 1. Connect to the DB server
        $conn = mysqli_connect('localhost', 'root', '');
        // 2. Choose which database I want to work on
        mysqli_select_db($conn, 'project_movie');

        //? sending the category details
        // PREPARE my query
        $catEquery = 'UPDATE playlist 
        SET name = "' . $_POST['plName'] . '" 
        WHERE name = "' . $_SESSION['playlist_title'] . '" 
        ';
        // var_dump($catEquery);

        // SEND query to the DB
        $catEresult = mysqli_query($conn, $catEquery);

        // success message to print
        $modDone = $_SESSION['playlist_title'] . ' has been changed to : ' . $_POST['plName'];

        // 3. CLOSE the resource/connection
        mysqli_close($conn);
    }

    // Click on the DELETE btn, delete permanently the selected playlist title 
    // (must delete all songs in it first)
    if (isset($_POST['delPL'])) {
        // 1. Connect to the DB server
        $conn = mysqli_connect('localhost', 'root', '');
        // 2. Choose which database I want to work on
        mysqli_select_db($conn, 'project_movie');

        //? getting the category details
        // PREPARE my query
        $delPLquery = "DELETE 
        FROM playlist 
        WHERE playlist_id = $playlistid
        ";

        // SEND query to the DB
        $delPLresult = mysqli_query($conn, $delPLquery);

        // success message to print
        $delDone = 'Your playlist has been permanently deleted.';

        // 3. CLOSE the resource/connection
        mysqli_close($conn);
    }


    ?>

    <!-- printing the playlist title and movies in it -->
    <?php foreach ($userPL as $userOnePL) : ?>
        <form action="" method="post">
            <span>Playlist : <strong><?= $userOnePL['name'] ?></strong></span>
            <input type="submit" name="subModPL" value="Modify this Playlist Name"><br>
            <!-- MODIFYING the PL name -->
            <?php if (isset($_POST['subModPL'])) : ?>
                <form action="" method="post">
                    <label for="plName">Edit Playlist Name to : </label>
                    <!-- autofill -->
                    <input type="text" name="plName" id="" value="<?= $_SESSION['playlist_title'] ?>">
                    <input type="submit" name="subModDone" value="Confirm Changes"><br>
                </form>
            <?php endif; ?>
            <p><?= $modDone ?></p>
            <input type="submit" name="delPL" value="Permanently Delete this Entire Playlist">
            <span><em>*Playlist cannot be deleted if not empty</em></span>
            <p><?= $delDone ?></p>
        </form>



        <!-- PHP looping in HTML printing -->
        <!-- ": + endforeach;" equivalent to "{ + }" -->
        <?php foreach ($movies as $movie) : ?>
            <form action="" method="post">
                <div>Movie : <strong><?= $movie['title'] ?></strong></div>
                <a href="http://localhost/Project/2-day-Project/delete_movie.php?playlist_id=<?= $userOnePL['playlist_id'] ?>&movie_id=<?= $movie['movie_id'] ?>">
                    <input type="button" value="Delete this movie fr PL">
                </a>
            </form>
        <?php endforeach; ?>
    <?php endforeach; ?>
</body>

</html>