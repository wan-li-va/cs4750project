<!DOCTYPE html>
<html lang="en">
<?php
require('connect-db.php');
include "./navbar.php";
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- required to handle IE -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- ICON  -->
    <link rel="shortcut icon" href="https://pngimg.com/uploads/paw/paw_PNG21.png" type="image/ico" />
    <!-- EXTERNAL CSS -->
    <link href="./styles/style.css" rel="stylesheet" type="text/css" />
</head>

<?php
//checks that the user is logged in
if (isset($_SESSION['user'])) {

    //checks that there is a course set to edit
    if (!isset($_SESSION['pName']) || !isset($_SESSION['pDOB'])) {
        echo "<script>
                alert('Nothing to edit, returning to pets');
                window.location.href='pets.php';
                </script>";
    }
    $pName = $_SESSION['pName'];
    $pDOB = $_SESSION['pDOB'];

    $query = "SELECT * FROM pets WHERE name = :name AND dob = :dob";
    $statement = $db->prepare($query);
    $statement->bindParam(':name', $pName);
    $statement->bindParam(':dob', $pDOB);
    $statement->execute();

    // fetchAll() returns an array for all of the rows in the result set
    $pet_info = $statement->fetchAll();
    // closes the cursor and frees the connection to the server so other SQL statements may be issued
    $statement->closecursor();
    $pieces = explode("-", $pet_info[0]['dob']);

    //checks for post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sex = $_POST['gender'];
        if ($sex == 'male') {
            $gender = 'M';
        } else {
            $gender = 'F';
        }

        $type = $_POST['type'];
        $color = $_POST['color'];
        $breed = $_POST['breed'];

        $is_vaccinated = $_POST['is_vaccinated'];
        $b_vaccinated = 0;
        if ($is_vaccinated == 'yes') {
            $b_vaccinated = 1;
        }
        $is_spayed_neutered = $_POST['is_spayed_neutered'];
        $b_spayed_neutered = 0;
        if ($is_spayed_neutered == 'yes') {
            $b_spayed_neutered = 1;
        }
        $is_adoptable = $_POST['is_adoptable'];
        $b_adoptable = 0;
        if ($is_adoptable == 'yes') {
            $b_adoptable = 1;
        }
        $is_fosterable = $_POST['is_fosterable'];
        $b_fosterable = 0;
        if ($is_fosterable == 'yes') {
            $b_fosterable = 1;
        }

        $shelter_name = $_POST['shelter_name'];
        $notes = $_POST['notes'];
        $image = $_POST['image'];

        $query = "UPDATE pets SET sex=:sex, type_of_animal=:type_of_animal,
                color=:color, breed=:breed, is_vaccinated=:is_vaccinated, 
                is_spayed_neutered=:is_spayed_neutered, shelter_name=:shelter_name, is_adoptable=:is_adoptable, 
                is_fosterable=:is_fosterable, notes=:notes, image=:image
                WHERE name=:name AND dob=:dob";
        $statement = $db->prepare($query);

        $statement->bindValue(':name', $pName);
        $statement->bindValue(':dob', $pDOB);
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
                alert('Pet updated');
                window.location.href='pets.php';
                </script>";
    }
?>

    <div class="container" style="text-align: center;">
        </br>
        <!-- a form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="editForm" method="post">

            <h4>
                Editing Pet <?php if (isset($pet_info[0]["name"])) {
                                echo $pet_info[0]["name"];
                            } ?>
            </h4>

            <div class="form-group">
                <br>
                <div class="form-row">
                    <div class="col">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender">
                            <option value="male">Male</option>
                            <option value="female" <?php if ($pet_info[0]["sex"] == "F") {
                                                        echo "selected";
                                                    } ?>>Female</option>
                        </select>
                    </div>
                </div>
                </br>
                <div class="form-row">
                    <div class="col">
                        <label for="type">Type of animal</label>
                        <input type="text" class="form-control" id="type" name="type" placeholder="Enter the type" required value="<?php echo $pet_info[0]['type_of_animal']; ?>">
                    </div>
                    <div class="col">
                        <label for="color">Color</label>
                        <input type="text" class="form-control" id="color" name="color" placeholder="Enter the color" required value="<?php echo $pet_info[0]['color']; ?>">
                    </div>
                    <div class="col">
                        <label for="breed">Breed</label>
                        <input type="text" class="form-control" id="breed" name="breed" placeholder="Enter the Breed" required value="<?php echo $pet_info[0]['breed']; ?>">
                    </div>
                </div>
                </br>
                <div class="form-row">
                    <div class="col">
                        <label for="is_vaccinated">Is Vaccinated</label>
                        <input type="hidden" name="is_vaccinated" value="no">
                        <input type="checkbox" class="form-control" id="is_vaccinated" name="is_vaccinated" value="yes" <?php if ($pet_info[0]['is_vaccinated']) {
                                                                                                                            echo "checked";
                                                                                                                        } ?>>
                    </div>
                    <div class="col">
                        <label for="is_spayed_neutered">Is Spayed/Neutered</label>
                        <input type="hidden" name="is_spayed_neutered" value="no">
                        <input type="checkbox" class="form-control" id="is_spayed_neutered" name="is_spayed_neutered" value="yes" <?php if ($pet_info[0]['is_spayed_neutered']) {
                                                                                                                                        echo "checked";
                                                                                                                                    } ?>>
                    </div>
                    <div class="col">
                        <label for="is_adoptable">Is Adoptable</label>
                        <input type="hidden" name="is_adoptable" value="no">
                        <input type="checkbox" class="form-control" id="is_adoptable" name="is_adoptable" value="yes" <?php if ($pet_info[0]['is_adoptable']) {
                                                                                                                            echo "checked";
                                                                                                                        } ?>>
                    </div>
                    <div class="col">
                        <label for="is_fosterable">Is Fosterable</label>
                        <input type="hidden" name="is_fosterable" value="no">
                        <input type="checkbox" class="form-control" id="is_fosterable" name="is_fosterable" value="yes" <?php if ($pet_info[0]['is_fosterable']) {
                                                                                                                            echo "checked";
                                                                                                                        } ?>>
                    </div>
                </div>

                </br>

                <div class="form-row">
                    <div class="col">
                        <label for="shelter_name">Shelter Name</label>
                        <input type="text" class="form-control" id="shelter_name" name="shelter_name" placeholder="Enter the shelter name" required value="<?php echo $pet_info[0]['shelter_name']; ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <label for="notes">Notes</label>
                        <input type="text" class="form-control" id="notes" name="notes" placeholder="Enter any notes" value="<?php if (isset($pet_info[0]["notes"])) {
                                                                                                                                    echo $pet_info[0]["notes"];
                                                                                                                                } ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <label for="image">Image Link</label>
                        <input type="text" class="form-control" id="image" name="image" placeholder="Enter url to image" value="<?php if (isset($pet_info[0]["image"])) {
                                                                                                                                    echo $pet_info[0]["image"];
                                                                                                                                } ?>">
                    </div>
                </div>


                </br>
                <div style="display: flex; flex-direction: row; height: 5vh; justify-content: center;">
                    <div class="row">
                        <div class="form-group col-md">
                            <button type="submit" class="btn btn-primary" style="margin-right: 1vw;">Submit</button>
                        </div>
                        </br>
                    </div>
                    <a class='btn btn-md' href='pets.php'> Cancel </a>
                </div>
        </form>


    </div>

<?php
} else {
    echo "<script>
                alert('Permission Denied');
                window.location.href='home.php';
                </script>";
}
?>