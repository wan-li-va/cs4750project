<!DOCTYPE html>
<html lang="en">
<?php 
    require('connect-db.php');
  ?>

<?php include "./navbar.php"; ?>

<?php
    //checks that the user is logged in
    if (isset($_SESSION['user'])){
        //checks that there is a course set to edit
        if (!isset($_SESSION['id']))
        {
            echo "<script>
                alert('Nothing to add, returning home');
                window.location.href='home.php';
                </script>";
        }
        //checks for post
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if (!empty($_POST['action']) && ($_POST['action'] == 'Cancel'))
            {
                unset($_SESSION['id']);
                header("Location: employees.php");
            }
            else
            {
                $query = "UPDATE users SET role=:role
                    WHERE username=:username";
                $statement = $db->prepare($query);
                $statement->bindValue(':role', 'employee');              
                $statement->bindValue(':username', $_SESSION['id']);
                $statement->execute();
                $statement->closeCursor();

                $shelter_name = $_POST['shelter_name'];
                $month = $_POST['start_month'];
                $day = $_POST['start_day'];
                $year = $_POST['start_year'];
                $start_Date = $year . "-" . $month . "-" . $day;
                $query = "INSERT INTO employees (username, shelter_name, start_date) 
                    VALUES (:username, :shelter_name, :start_date)";
                $statement = $db->prepare($query);
                $statement->bindValue(':username', $_SESSION['id']);
                $statement->bindValue(':shelter_name', $shelter_name);
                $statement->bindValue(':start_date', $start_Date);                
                $statement->execute();
                $statement->closeCursor();

                unset($_SESSION['id']);
                echo "<script>
                alert('User added into employees');
                window.location.href='admin.php';
                </script>";
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
    <!-- ICON  -->
    <link rel="shortcut icon" href="https://pngimg.com/uploads/paw/paw_PNG21.png" type="image/ico" />
    <!-- EXTERNAL CSS -->
    <link href="./styles/style.css" rel="stylesheet" type="text/css" />
</head>

<div class="container" style="text-align: center;">
      </br>
      <!-- a form -->
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="editForm" method="post">

        <h4>Are you sure you want to add <?php echo "User: "; echo $_SESSION['id'];?> to employees?</h4>
          
        <div class="form-group">
                <div class="form-row">
                    <div class = "col">
                        <label for="shelter_name">Shelter Name</label>
                        <input type="text" class="form-control" name="shelter_name" id="shelter_name" placeholder="Enter the shelter" required>
                    </div>
                </div>  
                <span class="error_message" id="msg_name"></span>  
            </div>
            </br>
            <div class="form-group">
                <h5>Start Date</h5>
                <div class="form-row">
                    
                    <div class = "col">
                        <label for="start_month">Start Month</label>
                        <input type="number" class="form-control" name="start_month" id="start_month" placeholder="Enter start month" required
                            maxlength="2" min="1" max="12">
                    </div>
                    <div class = "col">
                        <label for="start_day">Start Day</label>
                        <input type="number" class="form-control" name="start_day" id="start_day" placeholder="Enter start day" required
                            maxlength="2" min="1" max="31">
                    </div> 
                    <div class = "col">
                        <label for="start_year">Start Year</label>
                        <input type="number" class="form-control" name="start_year" id="start_year" placeholder="Enter start year" required
                            maxlength="4" min="1900" max="2021">
                    </div> 
                </div>  
                <span class="error_message" id="msg_name"></span>  
            </div>

            <div class="row">
                <div class="form-group col-md">
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                
            </div>
          
        </form>

        <div class="form-group col-md">
        <a class='btn btn-md' href='admin.php'> Cancel </a>
        </div>
          
  
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