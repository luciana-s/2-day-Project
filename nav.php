<?php

session_start();
var_dump($_SESSION);

?>

<!--  Home, Songs, Artists, Playlists and Register / Login -->
<nav>
    <a href="index.php">Home | </a><br>
    <a href="">| Movies Catalogue | </a><br>
    <a href="">| Manage Catagories | </a><br>
    <a href="">| Add a Movie | </a><br>
    <a href="playlists.php">| Playlists | </a><br>
    <a href="register.php">| Register | </a><br>
    <a href="login.php">| Log In</a><br>


    <input type="text" id="search" placeholder="Search for a movie...">

    <?php


    if ($_SESSION['login']) {
        echo 'Logged In : ' . $_SESSION['sessUser'] . '<br>';
    } else {
        // https://my.bluehost.com/hosting/help/241
        header("Location: http://localhost/PHP/PHPSpotify/login.php");
        // header("Location: login.php");
    }


    ?>

    <?php if ($_SESSION['login']) : ?>
        <div>Song : <strong><?= $playlist['Title'] ?></strong></div>
    <?php else : ?>
        <div>Song : <strong><?= $playlist['Title'] ?></strong></div>
    <?php endif; ?>

</nav>