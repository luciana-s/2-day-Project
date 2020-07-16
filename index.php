<?php
/* 
-Home page
The home page briefly introduces the concept and firstly, displays a large and wide search
field, for searching among the films.
A non-exhaustive list of categories is displayed. The number of films in each category
(displayed on the home page) is placed in brackets to the right of the category name.
The last added movies will also be displayed, along with their poster and name.

-Research
Search field should implement auto-completion on title. (query in DESC order, return top title)
When user type in, it should bring title matching.
*/

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <?php
    require_once('nav.php');
    ?>

    <!-- //? autofill search bar -->
    <form action="" method="post">
        <label for="mysearch">Instant KeyUp Search:</label>
        <input type="text" name="mysearch2" id="mysearch" placeholder="looking..." required>
        <input type="submit" name="search2" value="hunt!">
    </form>

    <img src="" alt="">

    <div id="resultForm">...</div>

    <?php

    //? manual click ENTER search bar 
    if (isset($_POST['search2'])) {
        // clean the string
        $searchTitle = trim($_POST['mysearch2']);

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


    // ? DISPLAY the latest 5 movies added to the DB
    // 1. Connect to the DB server
    // mysqli_connect() returns either FALSE (not connected) or info about the connection.
    $conn = mysqli_connect('localhost', 'root', '');

    // Choose which database I want to work on
    mysqli_select_db($conn, 'project_movie');

    if ($conn) {
        //? getting the movies
        // PREPARE my query
        $homequery = "SELECT * 
            FROM movies
            ORDER BY movie_id DESC
            LIMIT 7
            ";
        // SEND query to the DB
        $homeresults = mysqli_query($conn, $homequery);
        // get all movies queried
        $homemovies = mysqli_fetch_all($homeresults, MYSQLI_ASSOC);

        //? getting the categories
        // PREPARE my query
        $catquery = "SELECT m.cat_id, name, COUNT(title) 
            FROM movies m
            INNER JOIN categories c 
            ON m.cat_id = c.cat_id 
            GROUP BY m.cat_id
            ";
        // SEND query to the DB
        $catresults = mysqli_query($conn, $catquery);
        // get all movies queried
        $homecats = mysqli_fetch_all($catresults, MYSQLI_ASSOC);

        // CLOSE the resource/connection
        mysqli_close($conn);
    } else {
        echo 'Problem w cxn<br>';
    }

    ?>

    <!-- PHP looping in HTML printing -->
    <!-- ": + endforeach;" equivalent to "{ + }" -->

    <!-- print the home categories -->
    <?php foreach ($homecats as $homecat) : ?>
        <span>| <strong><?= $homecat['name'] ?></strong> (<?= $homecat['COUNT(title)'] ?>) |</span>
    <?php endforeach; ?>
    <hr>

    <!-- print the home movies -->
    <section id="indexSection">
        <?php foreach ($homemovies as $homemovie) : ?>
            <div class="shownMoviesIndex">
                <img src="imgs/<?= $homemovie['poster'] ?>" alt="">
                <p>Title : <strong><?= $homemovie['title'] ?></strong></p>
                <p>Release : <?= substr($homemovie['year_of_release'], 0, 4) ?></p>
                <!-- 5. Make the title of each movie clickable - redirect to the related descriptive movie page. -->
                <p><a href="http://localhost/Project/2-day-Project/movie_details.php?id=<?= $homemovie['movie_id'] ?>">See More...?</a></p>
            </div>
        <?php endforeach; ?>
    </section>


    <!-- https://code.jquery.com/ -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <!-- my own script -->
    <script>
        //? AJAX call to the PHP that queries the DB
        // same as done.ready: waits for everything to be loaded before executing
        $(function() {
            // $('#mysearch').keyup(function (e) {
            $('input[type="text"]').keyup(function(e) {
                e.preventDefault(); // safer but not strictly needed as there is no submit btn

                // each time a key is released, we are making an AJAX call
                $.ajax({
                    url: 'search-movie.php',
                    type: 'post',
                    data: {
                        mySearch: $('#mysearch').val()
                    },
                    success: function(result) {
                        console.log('Result of AJAX call : ' + result);
                        $('#resultForm').html('<h3>' + result + '</h3>');
                    },
                    error: function(error) {
                        // should hide from user
                        console.log('AJAX Error!');
                    },
                });
            });
        });
    </script>

</body>

</html>