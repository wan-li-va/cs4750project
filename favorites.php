<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- required to handle IE -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap" rel="stylesheet">
    <!-- ICON  -->
    <link rel="shortcut icon" href="https://media2.giphy.com/media/n9wqJ8gTR9lQnXTvf3/giphy_s.gif" type="image/ico" />
    <!-- EXTERNAL CSS -->
    <link href="./styles/style.css" rel="stylesheet" type="text/css" />
</head>
<?php
require('connect-db.php');
include "./navbar.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['action']) && ($_POST['action'] == 'Delete')) {
        $username = $_SESSION['user'];
        $name = $_POST['pName2'];
        $dob = $_POST['pDOB2'];
        $image = $_POST['pImg2'];

        $query = "DELETE FROM favorites WHERE username=:username AND name=:name AND dob=:dob AND image=:image";
        $statement = $db->prepare($query);

        $statement->bindValue(':username', $username);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':dob', $dob);
        $statement->bindValue(':image', $image);

        $statement->execute();
        $statement->closeCursor();


        echo "<script>
        alert('Pet has been deleted from favorites');
        window.location.href='favorites.php';
        </script>";
    }
}
?>

<body>
    <div class="body">
        <div class="sketchy">
            <h1 class="title"> Favorite Pets</h1>
        </div>

        <?php
        // Form the SQL query (a SELECT query)

        if (!isset($_SESSION['user'])) {
            echo "<script>
        alert('You are not logged in');
        window.location.href='login.php';
        </script>";
        }
        $user = $_SESSION['user'];
        $query = "SELECT * FROM favorites WHERE username = :username ORDER BY name";
        $statement = $db->prepare($query);
        $statement->bindParam(':username', $user);
        $statement->execute();
        $favorite_info = $statement->fetchAll();
        $statement->closecursor();

        $output = "<h2>Welcome to Purrfect Pets
            <div class='container'>
            <div class='row'>";

        echo "<div class='row'>";
        if (empty($favorite_info)) {
            echo "<div style='display: flex; flex-direction: column; align-items: center; justify-content: center;'>";
            echo "<h1>You have no favorites. Check out our pets!</h1>";
            echo "<a class='btn btn-primary' style='width: 10vw; height: 6vh; font-size: 120%; text-align: center; margin-top: 3vh;' 
                    href='pets.php'>Go to pets</a></div>";
        } else {
            foreach ($favorite_info as $row) {
                // $name = $row['name'];
                // $desciption = $row['desciption'];
                // $ephoto = $row['ephoto'];
                echo  "<div class='col-sm-3' style='width: 80vw;'>";
                echo  "<div class='card' style='height: 55vh; width: 21vw; margin-bottom: 5vh;'>";
                echo  "<div class='card-body'>";
                if ($row['image'] != NULL) {
                    echo "<img class='animalimg' img src='";
                    echo $image = $row['image'];
                    echo "' style='height: 15vh; margin-bottom: 2vh;'> </img>";
                } else {
                    echo "<img class='animalimg' style='height: 15vh; margin-bottom: 2vh;' 
                    img src='https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/480px-No_image_available.svg.png'> </img>";
                }
                echo "<h1 style='text-align:center'>";
                echo  $name =  $row['name'];
                echo "</h1>";

                //Birthdate
                echo "<p class='petsinfo'> <b> Birthdate (YYYY-MM-DD): </b>";
                echo $dob = $row['dob'];
                echo "</p>";

                echo "<div style='position: absolute; bottom: 5vh; align-items: center; justify-content: center;'>";
                echo '<form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"method="POST">';
                echo '<input class="btn btn-primary" type="submit" value="Delete" name="action" />';
                echo '<input type="hidden" name="pName2" value="' . $row['name'] . '" />';
                echo '<input type="hidden" name="pDOB2" value="' . $row['dob'] . '" />';
                echo '<input type="hidden" name="pImg2" value="' . $row['image'] . '" />';
                echo "</form>";
                echo "</div>";


                echo  "</div>";
                echo  "</div>";
                echo  "</div>";
            }
        }
