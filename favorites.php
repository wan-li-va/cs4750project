<!DOCTYPE html>
<html lang="en">

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
    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap" rel="stylesheet">
    <!-- ICON  -->
    <link rel="shortcut icon" href="https://media2.giphy.com/media/n9wqJ8gTR9lQnXTvf3/giphy_s.gif" type="image/ico" />
    <!-- EXTERNAL CSS -->
    <link href="./styles/style.css" rel="stylesheet" type="text/css" />
</head>

<?php include "./navbar.php" ?>

<body>
    <div class="body">

    <?php
    require_once('./connect-db.php');
    $con = new mysqli($hostname, $username, $password, $dbname);
    // Check connection
    if (mysqli_connect_errno()) {
    echo("Can't connect to MySQL Server. Error code: " .
    mysqli_connect_error());
    return null;
    }?>
<!-- 
    <table cellspacing='4' cellpadding='4'>
        <tr>
            <th>Name</th>
            <th>Date of Birth</th>
            <th>Type of Animal</th>
            <th>Color</th>
            <th>Breed</th>
            <th>Vaccinated</th>
            <th>Spayed/Neutered</th>
            <th>Shelter Name</th>
            <th>Adoptable</th>
            <th>Fosterable</th>
            <th>Notes</th>
            <th>Image</th>
        </tr> -->

    <?php
    // Form the SQL query (a SELECT query)
    $sql="SELECT * FROM favorites ORDER BY name";
    $result = mysqli_query($con,$sql);
    // Print the data from the table row by row
    // while($row = mysqli_fetch_array($result)) {
    //     echo "<td>" . $row['name'] . "</td>";
    //     echo "<td>" . $row['dob'] . "</td>";
    //     echo "<td>" . $row['sex'] . "</td>";
    //     echo "<td>" . $row['type_of_animal'] . "</td>";
    //     echo "<td>" . $row['color'] . "</td>";
    //     echo "<td>" . $row['breed'] . "</td>";
    //     echo "<td>" . $row['is_vaccinated'] . "</td>";
    //     echo "<td>" . $row['is_spayed_neutered'] . "</td>";
    //     echo "<td>" . $row['shelter_name'] . "</td>";
    //     echo "<td>" . $row['is_adoptable'] . "</td>";
    //     echo "<td>" . $row['is_fosterable'] . "</td>";
    //     echo "<td>" . $row['notes'] . "</td>";
    //     echo "<td>" . $row['notes'] . "</td>";
    //     echo "</tr>";
    // }
    
    $output="";
    $exeQuery = mysqli_query($con,$sql);

    $output="<h2>Welcome to Modern Business
            <div class='container'>
            <div class='row'>";
            
    echo "<div class='row'>";
    while($row = mysqli_fetch_array($exeQuery)) {
        // $name = $row['name'];
        // $desciption = $row['desciption'];
        // $ephoto = $row['ephoto'];
        echo "<div class='col-sm-6'>";
        echo  "<div class='card'>";
        echo  "<div class='card-body'>"; 
        
            if ($row['image'] != NULL) {
            echo "<img class='favoritesimg' img src='";
            echo $image = $row['image'];
            echo "'> </img>";
            }
            else {
                echo "<img class='favoritesimg' img src='https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/480px-No_image_available.svg.png'> </img>";
            }

            echo "<h1 style='text-align:center'>";
            echo  $name =  $row['name'];
            echo "</h1>";
            
            //Birthdate
            echo "<p class='petsinfo'> <b> Birthdate (YYYY-MM-DD): </b>";
            echo $dob = $row['dob'];
            echo "</p>";

            //adoptable
            echo "<p class='petsinfo'> <b>Adoptable: </b>";
            if ($row['is_adoptable' == "1"]) {
                echo "Up for Adoption";
            }
            else {
                echo "Not Up for Adoption";
            }
            echo "</p>";
            

            //fosterable
            echo "<p class='petsinfo'> <b>Fosterable: </b>";
            if ($row['is_fosterable' == "1"]) {
                echo "Up for Foster";
            }
            else {
                echo "Not Fosterable";
            }
            echo "</p>";

            echo  "</div>";
            echo  "</div>";
            echo  "</div>";
        }
    

    echo  "</div>";
    
    mysqli_close($con);
    ?>

    
    <!-- </table>
    <div class="card" style="width: 18rem;">
    <img class="card-img-top" src="..." alt="Card image cap">
    <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
    </div> -->

    
</div>
</div>
</body>