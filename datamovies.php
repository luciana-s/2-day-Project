<?php
$connection = mysqli_connect('localhost', 'root', '', 'project_movie');
if ($connection) {
    if (isset($_POST['order'])) {
        if ($_POST['order'] == 'date') {
            $query = 'SELECT * FROM movies ORDER BY `year_of_release` DESC';
            $result = mysqli_query($connection, $query);
            $db_records = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $movies = json_encode($db_records, JSON_PRETTY_PRINT);
            echo $movies;
        }
        if ($_POST['order'] == 'title') {
            $query = 'SELECT * FROM movies ORDER BY `title`';
            $result = mysqli_query($connection, $query);
            $db_records = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $movies = json_encode($db_records, JSON_PRETTY_PRINT);
            echo $movies;
        }
        if ($_POST['order'] == 'id') {
            $query = 'SELECT * FROM movies ORDER BY `movie_id`';
            $result = mysqli_query($connection, $query);
            $db_records = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $movies = json_encode($db_records, JSON_PRETTY_PRINT);
            echo $movies;
        }
    } else {
        $query = 'SELECT * FROM movies';
        $result = mysqli_query($connection, $query);
        $db_records = mysqli_fetch_all($result, MYSQLI_ASSOC);
        //var_dump($db_records);
        $movies = json_encode($db_records, JSON_PRETTY_PRINT);
        //var_dump(json_encode($db_records, JSON_PRETTY_PRINT));
        echo $movies;
    }
} else {
    echo 'no connection to the server';
}
