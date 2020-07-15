    <?php

    if (isset($_POST['logout'])) {

        $_SESSION['login'] = false;

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

        #userstat {
            text-align: right;
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
            <form id="userstat" action="" method="post">
                <input type="submit" name="logout" value="Log Out"><br>
                <div>Logged In User: <?= $_SESSION['sessUser'] ?></div>
                <div>User email: <?= $_SESSION['email'] ?></div>
            </form>
        <?php else : ?>
            <div>
                <a href="register.php">| Register |</a>
                <a href="login.php">| Log In |</a>
            </div>
        <?php endif; ?>
    </header>