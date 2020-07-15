<?php
$connection = mysqli_connect('localhost', 'root', '', 'project_movie');
if ($connection) {
    $query = 'SELECT * FROM movies';
    $result = mysqli_query($connection, $query);
    $db_records = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //var_dump($db_records);
    $movies = json_encode($db_records, JSON_PRETTY_PRINT);
    echo $movies;
    //var_dump(json_encode($db_records, JSON_PRETTY_PRINT));
} else {
    echo 'no connection to the server';
}
