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
        //checks that there is a donor selected to edit
        if (!isset($_SESSION['id']))
        {
            echo "<script>
                alert('Nothing to edit, returning home');
                window.location.href='home.php';
                </script>";
        }
        $last_name = $_SESSION['id'];

        $query = "SELECT * FROM donors WHERE last_name = :last_name";
        $statement = $db->prepare($query);
        $statement->bindParam(':last_name', $last_name);
        $statement->execute();
            
        // fetchAll() returns an array for all of the rows in the result set
        $user_info = $statement->fetchAll();
        // closes the cursor and frees the connection to the server so other SQL statements may be issued
        $statement->closecursor();
        $date = explode("-", $user_info[0]['donation_date']);

        //checks for post
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if (!empty($_POST['action']) && ($_POST['action'] == 'Cancel'))
            {
                unset($_SESSION['id']);
                header("Location: donors.php");
            }
            else
            {
                $shelter_name = $_POST['shelter_name'];
                $month = $_POST['donation_month'];
                $day = $_POST['donation_day'];
                $year = $_POST['donation_year'];
                $donation_date = $year . "-" . $month . "-" . $day;
                $donation_amount = $_POST['donation_amt'];
                $last_name = $user_info[0]["last_name"];

                $query = "UPDATE donors SET shelter_name=:shelter_name, donation_date=:donation_date, donation_amount=:donation_amount
                    WHERE last_name=:last_name";
                $statement = $db->prepare($query);
                $statement->bindValue(':shelter_name', $shelter_name);
                $statement->bindValue(':donation_date', $donation_date); 
                $statement->bindValue(':donation_amount', $donation_amount);                
                $statement->bindValue(':last_name', $last_name);
                $statement->execute();
                $statement->closeCursor();
                unset($_SESSION['id']);
                echo "<script>
                alert('Info updated');
                window.location.href='donors.php';
                </script>";
            }

        }
?>

<div class="container" style="text-align: center;">
      
        <h4>
            Editing Donor <?php if(isset($user_info[0]["first_name"])){echo $user_info[0]["first_name"] . " " . $user_info[0]["last_name"];}?>
        </h4>
        <!-- a form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="editForm" method="post">

            <div class="form-row">
                    <div class = "col">
                        <label for="shelter_name">Which shelter?</label>
                        <input type="text" class="form-control" id="shelter_name" name="shelter_name" placeholder="Enter the shelter name" required
                        value="<?php echo $user_info[0]['shelter_name'];?>">
                    </div>
                    <div class = "col">
                        <label for="donation_amt">Donation Amount</label>
                        <input type="number" class="form-control" id="donation_amt" name="donation_amt" placeholder="Amount (in $)" min="1" required
                        value="<?php echo $user_info[0]['donation_amount'];?>">
                    </div>
                </div>
                </br>
            <div class="form-group">
                <h5>Donation Date</h5>
                <div class="form-row">
                    <div class = "col">
                        <label for="donation_month">Donation Month</label>
                        <input type="number" class="form-control" id="donation_month" name="donation_month" placeholder="Enter month" required
                            maxlength="2" min="1" max="12"
                            value="<?php echo $date[1];?>">
                    </div>
                    <div class = "col">
                        <label for="donation_day">Donation Day</label>
                        <input type="number" class="form-control" id="donation_day" name="donation_day" placeholder="Enter day" required
                            maxlength="2" min="1" max="31"
                            value="<?php echo $date[2];?>">
                    </div> 
                    <div class = "col">
                        <label for="donation_year">Donation Year</label>
                        <input type="number" class="form-control" id="donation_year" name="donation_year" placeholder="Enter year" required
                            maxlength="4" min="1900" max="2021"
                            value="<?php echo $date[0];?>">
                    </div> 
                </div>  
                <span class="error_message" id="msg_name"></span>  
            </div>

            <div class="row">
                <div class="form-group col-md">
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </br>
                <div class="form-group col-md">
                <input type="submit" value="Cancel" name="action" class="btn btn-secondary" />
                </div>
            </div>
          
        </form>
          
  
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