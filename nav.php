    <?php

    if (isset($_POST['logout'])) {

        $_SESSION['login'] = false;
        echo 'Bye Bye Birdie<br>';
        // var_dump($_SESSION);
        // var_dump($_COOKIE);
    }

    ?>

    <style>
        header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        nav {
            display: flex;
        }
    </style>

    <!--  Home, Songs, Artists, Playlists and Register / Login -->
    <header>
        <nav>
            <a href="index.php">| Home | </a><br>
            <a href="">| Movies Catalogue | </a><br>
            <a href="">| Manage Catagories | </a><br>
            <a href="">| Add a Movie | </a><br>
            <a href="playlists.php">| Playlists | </a><br>
        </nav>

        <div>
            <input type="text" id="search" placeholder="Search for a movie...">
        </div>

        <?php if ($_SESSION['login']) : ?>
            <form action="" method="post">
                <input type="submit" name="logout" value="Log Out">
            </form>
        <?php else : ?>
            <div>
                <a href="register.php">| Register | </a>
                <a href="login.php">| Log In |</a>
            </div>
        <?php endif; ?>
    </header>