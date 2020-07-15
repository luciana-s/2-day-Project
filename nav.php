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

    if (isset($_POST['logout'])) {

        $_SESSION['login'] = false;
        echo 'Bye Bye Birdie<br>';
        var_dump($_SESSION);
        var_dump($_COOKIE);
    }


    ?>

    <?php if ($_SESSION['login']) : ?>
        <div>
            <input type="submit" name="logout" value="Log Out">
        </div>
    <?php else : ?>
        <div>
            <a href="register.php">
                <input type="button" name="register" value="Register">
            </a>
        </div>
        <div>
            <a href="login.php">
                <input type="button" name="login" value="Log In">
            </a>
        </div>
    <?php endif; ?>

</nav>