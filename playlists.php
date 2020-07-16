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
    <form action="" method="get">
        <input type="text" name="addPlaylist" placeholder="add a playlist" id="">
        <input type="submit" name="submitPL" value="Add New Playlist">
    </form>

    <?php
    // add new playlist
    if (isset($_GET['submitPL'])) {
        echo 'Adding new playlist<br>';

        $titlePL = $_GET['addPlaylist'];
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
            <button value='<?= $userOnePL['playlist_id'] ?>'>Edit playlist</button>
        </form>

        <!-- MODIFYING the category name -->
        <?php if (isset($_POST['subModifY'])) : ?>
            <form action="" method="post">
                <label for="catName">Edit Category Name to : </label>
                <!-- autofill -->
                <input type="text" name="catName" id="" value="<?= $_SESSION['category'] ?>">
                <input type="submit" name="subModDone" value="Confirm Changes">
            </form>
        <?php endif; ?>

        <p><?= $modDone ?></p>

        <?php
        // Click on the edit btn, modify the selected playlist. 
        if (isset($_POST['subModPL'])) {

            // 1. Connect to the DB server
            $conn = mysqli_connect('localhost', 'root', '');
            // 2. Choose which database I want to work on
            mysqli_select_db($conn, 'project_movie');


            //? getting the category details
            // PREPARE my query
            $PLquery = 'SELECT * 
        FROM playlist p 
        WHERE name = "' . $userOnePL['name'] . '"
        ';
            var_dump($PLquery);
            // SEND query to the DB
            $PLresult = mysqli_query($conn, $PLquery);
            // get all movies queried
            $editcat = mysqli_fetch_assoc($PLresult);

            // save for later use
            $_SESSION['category'] = $editcat['name'];

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
            $catEquery = 'UPDATE categories 
        SET name = "' . $_POST['catName'] . '" 
        WHERE name = "' . $_SESSION['category'] . '" 
        ';
            // var_dump($catEquery);

            // SEND query to the DB
            $catEresult = mysqli_query($conn, $catEquery);

            // success message to print
            $modDone = $_SESSION['category'] . ' has been changed to : ' . $_POST['catName'];

            // 3. CLOSE the resource/connection
            mysqli_close($conn);
        }

        ?>


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