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
    //checks that the user is logged in
    if (isset($_SESSION['user'])){
        //checks for post
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
                $name = $_POST['name'];
                $month = $_POST['month'];
                $day = $_POST['day'];
                $year = $_POST['year'];                
                $DOB = $year . "-" . $month . "-" . $day;
                $sex = $_POST['gender'];
                if($sex == 'male')
                {
                    $gender = 'M';
                }
                else
                {
                    $gender = 'F';
                }
                
                $type = $_POST['type'];
                $color = $_POST['color'];
                $breed = $_POST['breed'];

                $is_vaccinated = $_POST['is_vaccinated'];
                $b_vaccinated = 0;
                if($is_vaccinated == 'yes')
                {
                    $b_vaccinated = 1;
                } 
                $is_spayed_neutered = $_POST['is_spayed_neutered'];
                $b_spayed_neutered = 0;
                if($is_spayed_neutered == 'yes')
                {
                    $b_spayed_neutered = 1;
                }                 
                $is_adoptable = $_POST['is_adoptable'];
                $b_adoptable = 0;
                if($is_adoptable == 'yes')
                {
                    $b_adoptable = 1;
                } 
                $is_fosterable = $_POST['is_fosterable'];
                $b_fosterable = 0;
                if($is_fosterable == 'yes')
                {
                    $b_fosterable = 1;
                } 

                $shelter_name = $_POST['shelter_name'];
                $notes = $_POST['notes'];
                $image = $_POST['image'];

                $query = "INSERT INTO pets (name, dob, sex, type_of_animal, color, 
                breed, is_vaccinated, is_spayed_neutered, shelter_name, is_adoptable, 
                is_fosterable, notes, image) VALUES 
                (:name, :dob, :sex, :type_of_animal, :color, 
                :breed, :is_vaccinated, :is_spayed_neutered, :shelter_name, :is_adoptable, 
                :is_fosterable, :notes, :image)";
                $statement = $db->prepare($query);

                $statement->bindValue(':name', $name);
                $statement->bindValue(':dob', $DOB);
                $statement->bindValue(':sex', $gender);
                $statement->bindValue(':type_of_animal', $type);
                $statement->bindValue(':color', $color);
                $statement->bindValue(':breed', $breed);
                $statement->bindValue(':is_vaccinated', $b_vaccinated);
                $statement->bindValue(':is_spayed_neutered', $b_spayed_neutered);
                $statement->bindValue(':shelter_name', $shelter_name);
                $statement->bindValue(':is_adoptable', $b_adoptable);
                $statement->bindValue(':is_fosterable', $b_fosterable);
                $statement->bindValue(':notes', $notes);
                $statement->bindValue(':image', $image);               
                          
                $statement->execute();
                $statement->closeCursor();
                echo "<script>
                alert('Pet added to table');
                window.location.href='pets.php';
                </script>";
            

        }
?>

<div class="container" style="text-align: center;">
      </br>
      <!-- a form -->
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="editForm" method="post">

        <h4>Add a pet</h4>
          
        <div class="form-group">
            <div class="form-row">
                <div class = "col">
                    <label for="first_name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter the name" required>
                </div>
            </div>
            <div class="form-group">
                <h5>Date of Birth</h5>
                <div class="form-row">
                    <div class = "col">
                        <label for="month">Month</label>
                        <input type="number" class="form-control" id="month" name="month" placeholder="Enter month" required
                            maxlength="2" min="1" max="12">
                    </div>
                    <div class = "col">
                        <label for="day">Day</label>
                        <input type="number" class="form-control" id="day" name="day" placeholder="Enter day" required
                            maxlength="2" min="1" max="31">
                    </div> 
                    <div class = "col">
                        <label for="year">Year</label>
                        <input type="number" class="form-control" id="year" name="year" placeholder="Enter year" required
                            maxlength="4" min="1750" max="2021">
                    </div> 
                </div>  
            </div>
            <br>
            <div class="form-row">
                <div class = "col">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>
            </br>
            <div class="form-row">
                <div class = "col">
                    <label for="type">Type of animal</label>
                    <input type="text" class="form-control" id="type" name="type" placeholder="Enter the type" required>
                </div>
                <div class = "col">
                    <label for="color">Color</label>
                    <input type="text" class="form-control" id="color" name="color" placeholder="Enter the color" required>
                </div>
                <div class = "col">
                    <label for="breed">Breed</label>
                    <input type="text" class="form-control" id="breed" name="breed" placeholder="Enter the Breed" required>
                </div>
            </div>
            </br>
            <div class="form-row">
                <div class = "col">
                    <label for="is_vaccinated">Is Vaccinated</label>
                    <input type="hidden" name="is_vaccinated" value="no">
                    <input type="checkbox" class="form-control" id="is_vaccinated" name="is_vaccinated" value="yes">
                </div>
                <div class = "col">
                    <label for="is_spayed_neutered">Is Spayed/Neutered</label>
                    <input type="hidden" name="is_spayed_neutered" value="no">
                    <input type="checkbox" class="form-control" id="is_spayed_neutered" name="is_spayed_neutered" value="yes">
                </div>
                <div class = "col">
                    <label for="is_adoptable">Is Adoptable</label>
                    <input type="hidden" name="is_adoptable" value="no">
                    <input type="checkbox" class="form-control" id="is_adoptable" name="is_adoptable" value="yes">
                </div>
                <div class = "col">
                    <label for="is_fosterable">Is Fosterable</label>
                    <input type="hidden" name="is_fosterable" value="no">
                    <input type="checkbox" class="form-control" id="is_fosterable" name="is_fosterable" value="yes">
                </div>
            </div>
            
            </br>

            <div class="form-row">
                <div class = "col">
                    <label for="shelter_name">Shelter Name</label>
                    <input type="text" class="form-control" id="shelter_name" name="shelter_name" placeholder="Enter the shelter name" required>
                </div>
            </div>

            <div class="form-row">
                <div class = "col">
                    <label for="notes">Notes</label>
                    <input type="text" class="form-control" id="notes" name="notes" placeholder="Enter any notes">
                </div>
            </div>

            <div class="form-row">
                <div class = "col">
                    <label for="image">Image</label>
                    <input type="text" class="form-control" id="image" name="image" placeholder="Enter url to image">
                </div>
            </div>
            

            </br>
            <div class="row">
                <div class="form-group col-md">
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </br>
            </div>
        </form>
        <a class='btn btn-md' href='pets.php'> Cancel </a>
          
</div>

<?php
    }
    else
    {
        echo "<script>
                alert('Permission Denied');
                window.location.href='home.php';
                </script>";
    }
?>