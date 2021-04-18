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
    <link rel="shortcut icon" href="https://media2.giphy.com/media/n9wqJ8gTR9lQnXTvf3/giphy_s.gif" type="image/ico" />
    <!-- EXTERNAL CSS -->
    <link href="./styles/style.css" rel="stylesheet" type="text/css" />
</head>

<?php include "./navbar.php" ?>
<?php 
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") 
  {
      //creating the user in the database
      $user = $_POST['username1'];
      // $pass = password_hash($_POST['pass1'], PASSWORD_BCRYPT);
      $pass = $_POST['pass1'];
      $first = $_POST['first_name'];
      $last = $_POST['last_name'];
      $email = $_POST['Email1'];
      $phone = (int)$_POST['phone'];

      $query = "SELECT * FROM login WHERE username = :username";
      
      $statement = $db->prepare($query); 
      $statement->bindParam(':username', $user);
      $statement->execute();
      $results = $statement->fetchAll();
      $check = sizeof($results);
      $statement->closecursor();

      //making sure that the user doesn't exist in the database already
      if ($check == 0)
      {
          
          $_POST['taken'] = 0;
          $query = "INSERT INTO users (username, role, first_name, last_name, email_address, phone_num) 
              VALUES (:username, :role, :first_name, :last_name, :email_address, :phone_num)";
          $statement = $db->prepare($query);
          $statement->bindValue(':username', $user);
          $statement->bindValue(':role', 'guest');
          $statement->bindValue(':first_name', $first);
          $statement->bindValue(':last_name', $last);
          $statement->bindValue(':email_address', $email);
          $statement->bindValue(':phone_num', $phone);
          $statement->execute();
          $statement->closeCursor();

          $query = "INSERT INTO login (username, password) VALUES (:username, :password)";
          $statement = $db->prepare($query);
          $statement->bindValue(':username', $user);
          $hashed_password = password_hash($pass, PASSWORD_BCRYPT);
          $statement->bindValue(':password', $hashed_password);
          $statement->execute();
          $statement->closeCursor();

          header("Location: login.php");
      }  

  }     
 
 ?>

<body>
    <div class="body">
    <div class="container" style="text-align: center;">

<!-- one of the columns in the container -->
<!-- the sign up column -->
      <h3>
          Change User Settings
      </h3>
      <!-- registration form -->
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="RegisterForm" method="post" onsubmit="return checkRegistration()">

          <div class="form-group">
            <label for="exampleInputUsername">Username</label>
            <input type="text" class="form-control" name="username1" id="username1" placeholder="Enter username" >
            <span class="error_message" id="msg_user"><?php if(!empty($user)) echo "Username already taken, please 
              enter another"?></span>
          </div>
          
          <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control" name="pass1" id="pass1" placeholder="Password" >
              <span class="error_message" id="msg_pass"></span>
          </div>
          <div class="form-group">
              <label for="exampleInputPassword2">Re-enter Password</label>
              <input type="password" class="form-control" name="pass2" id="pass2" placeholder="Password" >
          </div>

          <div class="form-group">
              <div class="form-row">
                  <div class = "col">
                      <label for="first_name">First Name</label>
                      <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter your first name" 
                          value="<?php if(!empty($user)) echo $_POST['first_name']?>">
                  </div>
                  <div class = "col">
                      <label for="last_name">Last Name</label>
                      <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter your last name" 
                          value="<?php if(!empty($user)) echo $_POST['last_name']?>">
                  </div> 
              </div>  
              <span class="error_message" id="msg_name"></span>  
          </div>

          <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input type="email" class="form-control" name="Email1" id="Email1" placeholder="Enter email" 
                  value="<?php if(!empty($user)) echo $_POST['Email1']?>">
              <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
              <span class="error_message" id="msg_email"></span>
          </div>

          <div class ="form-group">
              <label for="phone">Phone Number</label>
              <input type="text" class = "form-control" name="phone" id="phone" placeholder="Enter your phone number" 
                  value="<?php if(!empty($user)) echo $_POST['phone']?>">
              <small id="Phone number help" class="form-text text-muted">Please enter a 10 digit phone number</small>
              <span class="error_message" id="msg_phone"></span>                        
          </div>
          
          <div>
            <span class="error_message" id="overall"></span>
          </div>
          
          <button type="submit" class="btn btn-secondary">Submit</button>
          
        </form>
    </div>
</body>