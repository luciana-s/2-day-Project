<?php
/* 
Page for adding/modifying a category
A drop-down menu at the top of the page lists all the categories in the database. 
By selecting a category in this menu, I choose to modify the selected category. 
The fields of the category add/change form are then pre-filled.
Leaving this drop-down menu empty, I then choose to add.
There is only one page allowing the addition and modification of a category.
The form contains only the name of the category.
*/

session_start();

$modDone = $addDone = '';

// ? A drop-down menu at the top of the page lists all the categories in the database.
// 1. Connect to the DB server
// mysqli_connect() returns either FALSE (not connected) or info about the connection.
$conn = mysqli_connect('localhost', 'root', '');

// Choose which database I want to work on
mysqli_select_db($conn, 'project_movie');

if ($conn) {

    //? getting the categories
    // PREPARE my query
    $catquery = "SELECT * 
    FROM categories c
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    require_once('nav.php');
    ?>

    <!-- A drop-down menu at the top of the page lists all the categories in the database. -->
    <form action="" method="post">
        <select name="oneCat" id="">
            <option value="">Select a Category to Modify</option>
            <?php foreach ($homecats as $homecat) : ?>
                <option value="<?= $homecat['name'] ?>"><?= $homecat['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" name="subModifY" value="Modify this cat">
    </form>

    <?php
    // By selecting a category in this menu, I choose to modify the selected category. 
    if (isset($_POST['subModifY'])) {
        // echo $_POST['oneCat'];

        // 1. Connect to the DB server
        $conn = mysqli_connect('localhost', 'root', '');
        // 2. Choose which database I want to work on
        mysqli_select_db($conn, 'project_movie');


        //? getting the category details
        // PREPARE my query
        $catquery = 'SELECT * 
        FROM categories c 
        WHERE name = "' . $_POST['oneCat'] . '"
        ';
        // SEND query to the DB
        $catresult = mysqli_query($conn, $catquery);
        // get all movies queried
        $editcat = mysqli_fetch_assoc($catresult);

        // save for later use
        $_SESSION['category'] = $editcat['name'];

        // 3. CLOSE the resource/connection
        mysqli_close($conn);
    }

    // MODIFYING the category name
    if (isset($_POST['subModDone'])) {
        // 1. Connect to the DB server
        $conn = mysqli_connect('localhost', 'root', '');
        // 2. Choose which database I want to work on
        mysqli_select_db($conn, 'project_movie');


        //? sending the category details
        // PREPARE my query
        $catEquery = 'UPDATE categories 
        SET name = "' . $_POST['catName'] . '" 
        WHERE name = "' . $_SESSION['category'] . '" 
        ';
        // var_dump($catEquery);

        // SEND query to the DB
        $catEresult = mysqli_query($conn, $catEquery);

        // success message to print
        $modDone = $_SESSION['category'] . ' has been changed to : ' . $_POST['catName'];

        // 3. CLOSE the resource/connection
        mysqli_close($conn);
    }

    // ADDING a new category
    if (isset($_POST['addCatDone'])) {
        // 1. Connect to the DB server
        $conn = mysqli_connect('localhost', 'root', '');
        // 2. Choose which database I want to work on
        mysqli_select_db($conn, 'project_movie');

        //? sending the category details
        // PREPARE my query
        $addCquery = 'INSERT INTO categories (name) VALUES ("' . $_POST['addCat'] . '") 
        ';

        // SEND query to the DB
        $addCresult = mysqli_query($conn, $addCquery);

        // success message to print
        $addDone = 'New Category "' . $_POST['addCat'] . '" has been added';

        // 3. CLOSE the resource/connection
        mysqli_close($conn);
    }

    ?>

    <!-- MODIFYING the category name -->
    <?php if (isset($_POST['subModifY'])) : ?>
        <form action="" method="post">
            <label for="catName">Edit Category Name to : </label>
            <!-- autofill -->
            <input type="text" name="catName" id="" value="<?= $_SESSION['category'] ?>">
            <input type="submit" name="subModDone" value="Confirm Changes">
        </form>
    <?php endif; ?>

    <p><?= $modDone ?></p>

    <!-- ADDING a new category -->
    <form action="" method="post">
        <label for="addCat">Add a Category : </label>
        <input type="text" name="addCat" id="" value="">
        <input type="submit" name="addCatDone" value="Add New Movie Category">
    </form>

    <p><?= $addDone ?></p>

</body>

</html>