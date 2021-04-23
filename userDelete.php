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
        //checks that there is a course set to edit
        if (!isset($_SESSION['id']))
        {
            echo "<script>
                alert('Nothing to delete, returning home');
                window.location.href='home.php';
                </script>";
        }
        //checks for post
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if (!empty($_POST['action']) && ($_POST['action'] == 'Cancel'))
            {
                unset($_SESSION['id']);
                header("Location: home.php");
            }
            else
            {
                $query = "SELECT * FROM employees WHERE username = :username";
                $statement = $db->prepare($query);
                $statement->bindParam(':username', $_SESSION['id']);
                $statement->execute();
                $user_info = $statement->fetchAll();
                if(count($user_info) > 0)
                {
                    $query = "DELETE FROM employees WHERE username=:username";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':username', $_SESSION['id']);
                    $statement->execute();
                    $statement->closeCursor();
                }                

                $query = "DELETE FROM users WHERE username=:username";
                $statement = $db->prepare($query);
                $statement->bindValue(':username', $_SESSION['id']);
                $statement->execute();
                $statement->closeCursor();
                unset($_SESSION['id']);
                echo "<script>
                alert('User removed from system');
                window.location.href='admin.php';
                </script>";
            }

        }
?>

<div class="container" style="text-align: center;">
      </br>
      <!-- a form -->
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="editForm" method="post">

        <h4>Are you sure you want to remove <?php echo "User: "; echo $_SESSION['id'];?> as an user</h4>
          
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

