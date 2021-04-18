<!DOCTYPE html>
<html lang="en">
<?php 
  require('connect-db.php');?>
    <head>
    <link rel="apple-touch-icon" sizes="180x180" href="icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="icon/favicon-16x16.png">
    <link rel="manifest" href="icon/site.webmanifest">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="./themes/purple.css">
        <link rel="stylesheet" id="switcher-id" href="">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        
        <meta name="author" content="Valerie Young">  
        <title>Purrfect Pets</title>  
        <style type="text/css">
            h1	{font-family: 'Rubik', Arial;
                }
            h2   {font-family: 'Rubik', 'Arial';
                  font-size: 25px;
                }
            p   {font-family: 'Rubik', 'Arial';
                }
        </style>
       
    </head>
    <body>
    <?php include "./navbar.php" ?>
    <?php

if(isset($_POST['submit'])){

    $user = $_POST['username'];
    $passwordstr = $_POST['password'];
    $query = "SELECT password FROM login WHERE username = '$user'";

    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
    
    if (!empty($results)){
        {
        //verify that the typed password matches the hashed password in the table
          if (password_verify($passwordstr, $results[0]['password'])) 
          {            
            $_SESSION['user'] = $user;
            header("Location: home.php");
          } 
          else{
            echo "That's the wrong password. Go back and try again.";
          }
        }
    }
      else{
        echo "This account doesn't exist.";
        header("Location: account_create.php");
        }
}
    
    ?>

      <div class="container">
        <div class="row">
            <div class="col-sm">    
                <div>
                    <h1>Login</h1>
                      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="login" name="insert" method="POST">
                        <div class="form-group">
                        <span class = "label">Username</span>
                          <input type="text" id="full_name" name="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <span class = "label">Password</span>
                          <input type="password" id="password" name="password" class="form-control">
                        </div>
                        <div class="form-group text-center">
                          <input type="submit" name="submit" value="Login" class="btn btn-primary py-3 px-5">
                        </div>

                        </form>
                    </div>
                </div>
              </div>
            </div>  
    </body>
</html>