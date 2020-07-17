<?php
/* 
Playlist
You should have add a link in the menu and call it ‘playlists’.
A playlist belongs to only one user. (one user can have many)
A playlist is represented by : a name, a date of creation and a list of movies. 
On this page you have :
- A button to add a new playlist (an empty form with only the name)
- A list of all playlists (with edit/delete(redirect + redirect) button).
On the catalogue page, each movie should have a button/icon to add to a playlist.

*/

session_start();

$modDone = '';

if ($_SESSION['login']) {
    echo 'Logged In : ' . $_SESSION['sessUser'] . '<br>';

    $userId = $_SESSION['userID'];

    // 1. Connect to the DB server
    // mysqli_connect() returns either FALSE (not connected) or info about the connection.
    $conn = mysqli_connect('localhost', 'root', '');

    // Choose which database I want to work on
    mysqli_select_db($conn, 'project_movie');

    // Get playlists
    // PREPARE my query
    $queryUserPL = "SELECT p.* 
    FROM playlist p 
    WHERE p.user_id = $userId 
    ";

    // SEND query to the DB
    $resultsUserPL = mysqli_query($conn, $queryUserPL);

    $userPL = mysqli_fetch_all($resultsUserPL, MYSQLI_ASSOC);

    // Get playlists
    // PREPARE my query
    $query = "SELECT p.*, c.movie_id, m.title
    FROM playlist p
    INNER JOIN playlist_content c
    ON p.playlist_id = c.playlist_id
    INNER JOIN movies m
    ON c.movie_id = m.movie_id
    WHERE p.user_id = $userId
    ";

    // SEND query to the DB
    $results = mysqli_query($conn, $query);

    $playlists = mysqli_fetch_all($results, MYSQLI_ASSOC);
} else {
    // https://my.bluehost.com/hosting/help/241
    header("Location: login.php");
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
    <?php
    require_once('nav.php');
    ?>

    <!-- form to add new playlist -->
    <form action="" method="post">
        <input type="text" name="addPlaylist" placeholder="add a playlist" id="">
        <input type="submit" name="submitPL" value="Add New Playlist">
    </form>

    <?php
    // add new playlist - (dont use GET) figure out how to stop sending the same information
    // figure out how to use AJAX here
    if (isset($_POST['submitPL'])) {
        echo 'Adding new playlist<br>';

        $titlePL = $_POST['addPlaylist'];
        $creationTime = date('Y-m-d');

        // PREPARE my query
        $addPLquery = 'INSERT INTO playlist (name, date_of_creation, user_id) 
        VALUES ("' . $titlePL . '", "' . $creationTime . '", "' . $userId . '")
        ';
        var_dump($addPLquery);

        // SEND query to the DB
        $addUresults = mysqli_query($conn, $addPLquery);
    }
    ?>

    <!-- print the playlists -->
    <?php foreach ($userPL as $userOnePL) : ?>

        <form action="" method="post">
            <div>Playlist : <strong><?= $userOnePL['name'] ?></strong></div>

            <div>Created : <?= $userOnePL['date_of_creation'] ?></div>
            <input type="submit" name="subModPL" value="Edit Playlist">
            <a href="http://localhost/PHP/2-day-Project/playlist.php?playlist_id=<?= $userOnePL['playlist_id'] ?>">
                <button value='<?= $userOnePL['playlist_id'] ?>'>Edit playlist (value btn)</button>
            </a>
            <a href="http://localhost/PHP/2-day-Project/playlist.php?playlist_id=<?= $userOnePL['playlist_id'] ?>">
                <input type="button" value="go to edit">
            </a>
            <a href="http://localhost/PHP/2-day-Project/playlist.php?playlist_id=<?= $userOnePL['playlist_id'] ?>">Test</a>
        </form>

        <!-- MODIFYING the category name, not ideal method, displays forms for ALL lists upon click -->
        <?php if (isset($_POST['subModPL'])) : ?>
            <!-- <form action="" method="post">
                <label for="plName">Edit Category Name to : </label>
                // autofill 
                <input type="text" name="plName" id="" value="<?= $userOnePL['name'] ?>">
                <input type="submit" name="subModDone" value="Confirm Changes">
            </form> -->
        <?php endif; ?>

        <p><?= $modDone ?></p>

        <!-- PHP looping in HTML printing -->
        <!-- ": + endforeach;" equivalent to "{ + }" -->
        <?php foreach ($playlists as $playlist) : ?>
            <!-- https://www.php.net/manual/en/control-structures.alternative-syntax.php -->
            <?php if ($userOnePL['playlist_id'] == $playlist['playlist_id']) : ?>
                <div>Movie : <strong><?= $playlist['title'] ?></strong></div>
            <?php endif; ?>
        <?php endforeach; ?>
        <hr>
    <?php endforeach; ?>

</body>

</html>