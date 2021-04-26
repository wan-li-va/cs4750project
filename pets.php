<!DOCTYPE html>
<html lang="en">

<?php 
    require('connect-db.php');
    include "./navbar.php"; 

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if (!empty($_POST['action']) && ($_POST['action'] == 'Update'))
            {
                $_SESSION['pName'] = $_POST['pName'];
                $_SESSION['pDOB'] = $_POST['pDOB'];            
                header("Location: petUpdate.php");
            }
            if (!empty($_POST['action']) && ($_POST['action'] == 'Favorite'))
            {
                $_SESSION['pName2'] = $_POST['pName2'];
                $_SESSION['pDOB2'] = $_POST['pDOB2'];
                $_SESSION['pImg2'] = $_POST['pImg2'];                
                header("Location: favoritesAdd.php");
            }
        }

    $loggedIn = False;
    $manager = False;
    if (isset($_SESSION['user']))
    {
        $loggedIn = True;
        $user = $_SESSION['user'];

        $query = "SELECT * FROM users WHERE username = :username";
        $statement = $db->prepare($query);
        $statement->bindParam(':username', $user);
        $statement->execute();
                
        // fetchAll() returns an array for all of the rows in the result set
        $user_info = $statement->fetchAll();
                
        // closes the cursor and frees the connection to the server so other SQL statements may be issued
        $statement->closecursor();
        if($user_info[0]['role'] == 'admin' || $user_info[0]['role'] == 'manager')
        {
            $manager = True;
        }       
    
    }    
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
    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap" rel="stylesheet">
    <!-- ICON  -->
    <link rel="shortcut icon" href="https://pngimg.com/uploads/paw/paw_PNG21.png" type="image/ico" />
    <!-- EXTERNAL CSS -->
    <link href="./styles/style.css" rel="stylesheet" type="text/css" />
</head>


<body>
    <div class="body">
        <div class="sketchy">
            <h1 class="title"> Pets</h1>
        </div>
        <?php
        if($loggedIn)
        echo "<a class='btn btn-lg' href='favorites.php'> Your Favorite Pets </a>";
        ?>
        <br>
        <?php
        if($manager)
        {
            echo "<a class='btn btn-lg' href='petAdd.php'> Add a pet </a>";
        }
        
        ?>
        <br>

    <?php
    // Form the SQL query (a SELECT query)
    
    
    $query="SELECT * FROM pets ORDER BY name";
    $statement = $db->prepare($query);
    $statement->execute();
    $pets_info = $statement->fetchAll();
    $statement->closecursor();

    $output="<h2>Welcome to Modern Business
            <div class='container'>
            <div class='row'>";
            
    echo "<div class='row'>";
    foreach($pets_info as $row) {
        // $name = $row['name'];
        // $desciption = $row['desciption'];
        // $ephoto = $row['ephoto'];
        echo "<div class='col-sm-3'>";
        echo  "<div class='card'>";
        echo  "<div class='card-body'>"; 

        if ($row['image'] != NULL) {
        echo "<img class='animalimg' img src='";
        echo $image = $row['image'];
        echo "'> </img>";
        }
        else {
            echo "<img class='animalimg' img src='https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/480px-No_image_available.svg.png'> </img>";
        }

        echo "<h1 style='text-align:center'>";
        echo  $name =  $row['name'];
        echo "</h1>";
        
        //Birthdate
        echo "<p class='petsinfo'> <b> Birthdate (YYYY-MM-DD): </b>";
        echo $dob = $row['dob'];
        echo "</p>";

        //Sex, ASSUME THE LETTER IS CAPITALIZED
        echo "<p class='petsinfo'> <b> Sex: </b>";
        if ($row['sex'] == "F") {
            echo "Female";
        }
        else {
            echo "Male";
        }
        echo "</p>";

        //Type of Animal
        echo "<p class='petsinfo'> <b> Animal: </b>";
        echo $type = $row['type_of_animal'];
        echo "</p>";

        //Color
        echo "<p class='petsinfo'> <b> Color: </b>";
        echo $color = $row['color'];
        echo "</p>";

        //Breed
        echo "<p class='petsinfo'> <b> Breed: </b>";
        echo $breed = $row['breed'];
        echo "</p>";


        // Vaccinations
        echo "<p class='petsinfo'> <b> Vaccinations: </b>";
        if ($row['is_vaccinated'] == 1) {
            echo "Up to Date";
        }
        else {
            echo "Missing";
        }
        echo "</p>";

        //spayed/neutered
        echo "<p class='petsinfo'> <b>Spayed/Neutered: </b>";
        if ($row['is_spayed_neutered'] == 1) {
            echo "Yes";
        }
        else {
            echo "No";
        }
        echo "</p>";


        //shelter
        echo "<p class='petsinfo'> <b>Current Shelter: </b>";
        echo $shelter = $row['shelter_name'];
        echo "</p>";

        //adoptable
        echo "<p class='petsinfo'> <b>Adoptable: </b>";
        if ($row['is_adoptable'] == 1) {
            echo "Up for Adoption";
        }
        else {
            echo "Not Up for Adoption";
        }
        echo "</p>";
        

        //fosterable
        echo "<p class='petsinfo'> <b>Fosterable: </b>";
        if ($row['is_fosterable'] == 1) {
            echo "Up for Foster";
        }
        else {
            echo "Not Fosterable";
        }
        echo "</p>";

        //extra notes
        echo "<p class='petsinfo'> <b>Extra notes: </b>";
        echo $notes = $row['notes'];
        echo "</p>";

        //pet edit
        echo "<p class='petsinfo'>";
        echo '<form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"method="post">';
        echo "<div style='text-align:center'>";
        echo '<input type="submit" value="Update" name="action" class="btn btn-primary" style="margin-right:2em;"/>';
        echo '<input type="hidden" name="pName" value="' . $row['name'] .'" />';
        echo '<input type="hidden" name="pDOB" value="' . $row['dob'] .'" />';
        echo "</div>";
        echo "</form>";

        
        echo '<form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"method="post">';
        echo '<input class="btn btn-primary" type="submit" value="Favorite" name="action" />';
        echo '<input type="hidden" name="pName2" value="' . $row['name'] .'" />';
        echo '<input type="hidden" name="pDOB2" value="' . $row['dob'] .'" />';
        echo '<input type="hidden" name="pImg2" value="' . $row['image'] .'" />';
        echo "</form>";
        
        //idk if these closing tags for this section

        echo  "</div>";
        echo  "</div>";
        echo  "</div>";
    
    }    
    echo  "</div>";
    // $name =  $row['name'];
    //     $dob = $row['dob'];
    //     $sex =  $row['sex'] ;
    //     $type = $row['type_of_animal'] ;
    //     $color = $row['color'] ;
    //     $breed = $row['breed'];
    //     $vax = $row['is_vaccinated'];
    //     $spayed = $row['is_spayed_neutered'];
    //     $shelter = $row['shelter_name'];
    //     $adopt = $row['is_adoptable'];
    //     $foster = $row['is_fosterable'];
    //     $notes = $row['notes'];
    
    //mysqli_close($con);
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
<button class="scrollToTopBtn">▲</button>
</body>

<script>
var scrollToTopBtn = document.querySelector(".scrollToTopBtn")
var rootElement = document.documentElement

function handleScroll() {
  // Do something on scroll
  var scrollTotal = rootElement.scrollHeight - rootElement.clientHeight
  if ((rootElement.scrollTop / scrollTotal ) > 0.20) {
    // Show button
    scrollToTopBtn.classList.add("showBtn")
  } else {
    // Hide button
    scrollToTopBtn.classList.remove("showBtn")
  }
}

function scrollToTop() {
  // Scroll to top logic
  rootElement.scrollTo({
    top: 0,
    behavior: "smooth"
  })
}
scrollToTopBtn.addEventListener("click", scrollToTop)
document.addEventListener("scroll", handleScroll)
</script>