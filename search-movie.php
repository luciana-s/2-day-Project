<?php

var_dump($_POST);

// do something only if i get data
if (!empty($_POST && isset($_POST['mySearch']))) {
    // clean the string
    $searchTitle = trim($_POST['mySearch']);

    // open a connection to DB
    $conn = mysqli_connect('localhost', 'root', '', 'project_movie');

    $query = "SELECT * FROM movies WHERE title LIKE '%$searchTitle%'";

    // send SQL request to DB
    $result_query = mysqli_query($conn, $query);

    $foundmovies = mysqli_fetch_all($result_query, MYSQLI_ASSOC);
    // var_dump($foundmovies);

    // JSON file data format = just a type of string
    // Easy to transfer, and fast; Readable
    // echo json_encode($foundmovies, JSON_PRETTY_PRINT);

    if ($result_query) {
        // echo '<div style="color: forestgreen;">Movies found : </div>';
        foreach ($foundmovies as $key => $value) {
            // echo $value['poster'];
            echo $value['title'] . '<br>';
        }
    } else {
        echo '<div style="color: darkred;">Error inserting into the DB</div>';
    }

    // CLOSE the resource/connection
    mysqli_close($conn);
}
