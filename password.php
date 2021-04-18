<html>
  <?php 
    require('connect-db.php');
  ?>

  <style>
    .error_message {  color: crimson; font-style:italic; }       
  </style>

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
    <link rel="shortcut icon" href="https://media2.giphy.com/media/n9wqJ8gTR9lQnXTvf3/giphy_s.gif" type="image/ico" />
    <!-- EXTERNAL CSS -->
    <link href="./styles/style.css" rel="stylesheet" type="text/css" />
</head>
<?php include "./navbar.php";
    if (isset($_SESSION['user']))
    {
        $user = $_SESSION['user'];

        $query = "SELECT * FROM login WHERE username = :username";
        $statement = $db->prepare($query);
        $statement->bindParam(':username', $user);
        $statement->execute();
            
        // fetchAll() returns an array for all of the rows in the result set
        $user_info = $statement->fetchAll();
            
        // closes the cursor and frees the connection to the server so other SQL statements may be issued
        $statement->closecursor();

        if( !empty($_POST['pass1']) && !empty($_POST['pass']) && !empty($_POST['pass2']))
        {
            //meant to be used to allow for error checking
            if (isset($_SESSION["pass"]))
            {
                unset($_SESSION["pass"]);
            }
            //checks that both passwords match
            if( $_POST['pass1'] == $_POST['pass2'] && (password_verify($_POST['pass'], $user_info[0]['password'])))
            {
                
                $user = $_SESSION['user'];
                $pass = password_hash($_POST['pass1'], PASSWORD_BCRYPT);
                $query = "UPDATE login SET password=:password WHERE username=:username";
                $statement = $db->prepare($query);
                $statement->bindValue(':password', $pass);
                $statement->bindValue(':username', $user);
                $statement->execute();
                $statement->closeCursor();
                $_SESSION["pass_error"] = "";
                header("Location: home.php");
            }
        }
        //shows the error message
        else {
            $_SESSION["pass"] = "yes";
        }
?>

    <body>
        <div class="body">
        <div class="container" style="text-align: center;">

    <!-- one of the columns in the container -->
    <!-- the sign up column -->
        <h3>
            Change Password
        </h3>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="passform" method="post">
            <span class="error_message" id="pass_error"><?php if(!empty($_POST['pass1'])&&!empty($_POST['pass'])&&!empty($_POST['pass2'])) 
                echo "Your Passwords do not match or your current password is wrong";?></span>
            <br/>
            <span class="error_message" id="pass_error"><?php if(isset($_SESSION["pass"]) && $_SERVER["REQUEST_METHOD"] == "POST") 
                echo "All blanks must be filled in";?></span>

            <div class="form-group">
                <label for="exampleInputPassword1">Current Password</label>
                <input type="password" class="form-control" name="pass" id="pass" placeholder="Password" >
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">New Password</label>
                <input type="password" class="form-control" name="pass1" id="pass1" placeholder="Password" >
            
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Re-enter New Password</label>
                <input type="password" class="form-control" name="pass2" id="pass2" placeholder="Password" >
            </div>

            <button type="submit" class="btn btn-danger">Submit</button>

        </form>
    </body>

    <?php 
        }
        else
        {
    ?>
    <body>
        <div class="body">
        <div class="container" style="text-align: center;">
        <h4>
            You are not logged in.
        </h4>
        <a class="btn btn-primary" href="home.php">Return Home</a>
    </body>

    <?php
        }
    ?>

</html>