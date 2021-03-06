<!DOCTYPE html>
<html lang="en">
<?php
require('connect-db.php');
include "./navbar.php";

if (isset($_POST['submit'])) {

  $user = $_POST['username'];
  $passwordstr = $_POST['password'];
  $query = "SELECT password FROM login WHERE username = '$user'";

  $statement = $db->prepare($query);
  $statement->execute();
  $results = $statement->fetchAll();

  if (!empty($results)) { {
      //verify that the typed password matches the hashed password in the table
      if (password_verify($passwordstr, $results[0]['password'])) {
        $_SESSION['user'] = $user;
        header("Location: home.php");
      } else {
        echo "<div class=\"text-center\">That's the wrong password. Please try again.</div>";
      }
    }
  } else {
    echo "<div class=\"text-center\" style='margin-top: 1vh;'>That account doesn't exist.</div>";
  }
}
?>

<head>
  <link rel="apple-touch-icon" sizes="180x180" href="icon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="icon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="icon/favicon-16x16.png">
  <link rel="manifest" href="icon/site.webmanifest">
  <link rel="shortcut icon" href="https://pngimg.com/uploads/paw/paw_PNG21.png" type="image/ico" />
  <!-- FONT -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="./styles/style.css">
  <link rel="stylesheet" id="switcher-id" href="">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="author" content="Valerie Young">
  <title>Purrfect Pets</title>
  <style type="text/css">
    h1 {
      font-family: 'Rubik', Arial;
    }

    h2 {
      font-family: 'Rubik', 'Arial';
      font-size: 25px;
    }

    p {
      font-family: 'Rubik', 'Arial';
    }
  </style>

</head>

<body>

  <div class="container">
    <div class="row">
      <div class="col-sm">
        <div>
          <h1 style="margin-top: 5vh;">Login</h1>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="login" name="insert" method="POST">
            <div class="form-group">
              <span class="label">Username</span>
              <input type="text" id="full_name" name="username" class="form-control" required>
            </div>
            <div class="form-group">
              <span class="label">Password</span>
              <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group text-center">
              <input type="submit" name="submit" value="Login" class="btn btn-primary py-3 px-5" style="width: 15vw;">
            </div>

          </form>
        </div>

        <div class="text-center">
          <h5>OR</h5>
          <a href="account_create.php" class="btn btn-primary py-3 px-5" style="margin-top: 1vh;">Create an Account </a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>