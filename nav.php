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

        <form action="" method="post">
            <input type="text" name="mysearch1" placeholder="Search for a movie...">
            <input type="submit" name="search1" value="find movies">
        </form>

        <?php if (!isset($_SESSION['login']) || $_SESSION['login'] == false) : ?>
            <div>
                <a href="register.php">| Register |</a>
                <a href="login.php">| Log In |</a>
            </div>
        <?php elseif ($_SESSION['login']) : ?>
            <form id="userstat" action="" method="post">
                <input type="submit" name="logout" value="Log Out"><br>
                <div>Logged In User: <?= $_SESSION['sessUser'] ?></div>
                <div>User email: <?= $_SESSION['email'] ?></div>
            </form>
        <?php endif; ?>
    </header>

    <p>
        <?php

        if (isset($_POST['search1'])) {
            // clean the string
            $searchTitle = trim($_POST['mysearch1']);

            // open a connection to DB
            $conn = mysqli_connect('localhost', 'root', '', 'project_movie');

            $query = "SELECT * FROM movies WHERE title LIKE '%$searchTitle%'";

            // send SQL request to DB
            $result_query = mysqli_query($conn, $query);

            $foundmovies = mysqli_fetch_all($result_query, MYSQLI_ASSOC);
            // var_dump($foundmovies);


            foreach ($foundmovies as $key => $value) {
                echo '<img src="imgs/' . $value['poster'] . '" width="150px" alt=""><br>';
                echo $value['title'] . '<br>';
            }

            // CLOSE the resource/connection
            mysqli_close($conn);
        }

        ?>
    </p>