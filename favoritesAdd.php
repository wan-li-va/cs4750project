<!DOCTYPE html>
<html lang="en">
<?php 
    require('connect-db.php');
  ?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- required to handle IE -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <!-- ICON  -->
    <link rel="shortcut icon" href="https://pngimg.com/uploads/paw/paw_PNG21.png" type="image/ico" />
    <!-- EXTERNAL CSS -->
    <link href="./styles/style.css" rel="stylesheet" type="text/css" />
</head>

<?php include "./navbar.php"; ?>

<?php
echo $_SERVER["REQUEST_METHOD"];
    //checks that the user is logged in
    if (isset($_SESSION['user'])){
        //checks for post
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo "working";
                $pName = $POST['pName2'];
                $pDOB = $_SESSION['pDOB2'];
                $pImg = $_SESSION['pImg2'];

                $username = $_SESSION['user'];
                $name = $_POST['pName2'];
                $dob = $_POST['pDOB2'];
                $image = $_POST['pImg2'];
                $query = "INSERT INTO favorites (username, name, dob, image) 
                    VALUES (:username, :name, :dob, :image)";
                $statement = $db->prepare($query);
                $statement->bindValue(':username', $username);
                $statement->bindValue(':name', $name);
                $statement->bindValue(':dob', $dob);                
                $statement->bindValue(':image', $image);
                $statement->execute();
                $statement->closeCursor();
                echo "<script>
                alert('Pet added to favorites');
                window.location.href='pets.php';
                </script>";
        }
        else {
            echo "not working";
        }
    }
?>
