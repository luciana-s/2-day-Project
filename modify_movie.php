<?php
require_once 'nav.php';
session_start();

$connection = mysqli_connect('localhost', 'root', '', 'project_movie');
if ($connection) {
    $idError = $modifySusccess = $addSusccess = '';
    if (isset($_GET['id'])) {
        //Getting the movie from the id
        $urlID = $_GET['id'];
        $queryURL = "SELECT * FROM movies WHERE movie_id = $urlID";
        $resultURL = mysqli_query($connection, $queryURL);
        $db_record = mysqli_fetch_assoc($resultURL);
    }
} else {
    echo 'no connection to the server';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <!--MODIFY MOVIE-->
    <?php if (isset($_GET['id'])) : ?>
        <title>Modify movie</title>
        <!--action="modify_movie_data.php"  -->
        <form method="POST">
            <!--title-->
            <label for="title">title : </label>
            <input type="text" name="title" value="<?php echo $db_record['title']; ?>"><br>
            <!--date-->
            <label for="year_of_release">release date : </label>
            <input type="date" name="year_of_release" value="<?php echo $db_record['year_of_release']; ?>"><br>
            <!--poster-->
            <label for="poster"> path to poster: </label>
            <input type="text" name="poster" value="<?php echo $db_record['poster']; ?>"><br>
            <!--path-->
            <label for="path"> path to movie: </label>
            <input type="text" name="path" value="<?php echo $db_record['path']; ?>"><br>
            <!--sinopsis-->
            <label for="sinopsis"> sinopsis: </label>
            <textarea name="sinopsis" id="" cols="30" rows="10"><?php echo $db_record['sinopsis']; ?></textarea><br>
            <!--SUBMIT-->
            <input type="submit" value="modify" name="submit_modify">
        </form>
    <?php endif; ?>

    <!--ADD MOVIE-->
    <?php if (!isset($_GET['id'])) : ?>
        <h2>Add a movie</h2>
        <h3>To modify a movie, choose one from the <a href="http://localhost/Project/2-day-Project/catalogue.php">catalogue</a></h3>
        <form action="" method="POST">
            <!--title-->
            <label for="title">title : </label>
            <input type="text" name="title"><br>
            <!--date-->
            <label for="year_of_release">release date : </label>
            <input type="date" name="year_of_release"><br>
            <!--poster-->
            <label for="poster"> path to poster: </label>
            <input type="text" name="poster"><br>
            <!--path-->
            <label for="path"> path to movie: </label>
            <input type="text" name="path"><br>
            <!--sinopsis-->
            <label for="sinopsis"> sinopsis: </label>
            <textarea name="sinopsis" id="" cols="30" rows="10"></textarea>
            <!--SUBMIT-->
            <input type="submit" value="submit" name="submit_add">
        </form>
    <?php endif; ?>

    <?php
    if ($connection) {
        //* Modifyin a movie
        if (isset($_REQUEST['submit_modify'])) {
            //variables
            $title = $_REQUEST['title'];
            $year_of_release = $_REQUEST['year_of_release'];
            $poster = $_REQUEST['poster'];
            $path = $_REQUEST['path'];
            $sinopsis = $_REQUEST['sinopsis'];
            //query
            $queryModify = "UPDATE `movies` SET title = '$title', year_of_release = '$year_of_release', poster= '$poster',
                `path` = '$path', sinopsis = '$sinopsis'
                WHERE movie_id = $urlID ";
            $result = mysqli_query($connection, $queryModify);
            if ($result) {
                echo 'Modification succesful!';
                //putting the new values into the inputs
                $db_record['title'] = $title;
                $db_record['year_of_release'] = $year_of_release;
                $db_record['poster'] = $poster;
                $db_record['path'] = $path;
                $db_record['sinopsis'] = $sinopsis;
            }
        }
        //* Adding a movie
        if (isset($_POST['submit_add'])) {
            //variables
            $title = $_POST['title'];
            $year_of_release = $_POST['year_of_release'];
            $poster = $_POST['poster'];
            $path = $_POST['path'];
            $sinopsis = $_POST['sinopsis'];
            //query
            $queryAdd = "INSERT INTO `movies`(title , year_of_release , poster ,
                `path`, sinopsis)
                VALUE ('$title','$year_of_release', '$poster', '$path', '$sinopsis')";
            $result = mysqli_query($connection, $queryAdd);
            if ($result)
                echo 'Submition succesful!';
        }
    }
    ?>
</body>

</html>