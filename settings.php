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

<?php include "./navbar.php"; 

    if (isset($_SESSION['user'])){

        $user = $_SESSION['user'];

        $query = "SELECT * FROM users WHERE username = :username";
        $statement = $db->prepare($query);
        $statement->bindParam(':username', $user);
        $statement->execute();
            
        // fetchAll() returns an array for all of the rows in the result set
        $user_info = $statement->fetchAll();
            
        // closes the cursor and frees the connection to the server so other SQL statements may be issued
        $statement->closecursor();


        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        
            $user = $_SESSION['user'];
            $first = $_POST['first_name'];
            $last = $_POST['last_name'];
            $email = $_POST['Email1'];
            $phone = (int)$_POST['phone'];
        
            $query = "UPDATE users SET first_name=:first_name, last_name=:last_name,
                email_address=:email_address, phone_num=:phone_num
                WHERE username=:username";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $user);
            $statement->bindValue(':first_name', $first);
            $statement->bindValue(':last_name', $last);
            $statement->bindValue(':email_address', $email);
            $statement->bindValue(':phone_num', $phone);
            $statement->execute();
            $statement->closeCursor();

            echo "<script>
                alert('Settings Changed');
                window.location.href='home.php';
                </script>";
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
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="SettingsForm" method="post" onsubmit="return checkRegistration()">

          <div class="form-group">
              <div class="form-row">
                  <div class = "col">
                      <label for="first_name">First Name</label>
                      <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter your first name" 
                          value="<?php echo $user_info[0]['first_name'];?>">
                  </div>
                  <div class = "col">
                      <label for="last_name">Last Name</label>
                      <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter your last name" 
                          value="<?php echo $user_info[0]['last_name'];?>">
                  </div> 
              </div>  
              <span class="error_message" id="msg_name"></span>  
          </div>

          <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input type="email" class="form-control" name="Email1" id="Email1" placeholder="Enter email" 
                  value="<?php echo $user_info[0]['email_address'];?>">
              <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
              <span class="error_message" id="msg_email"></span>
          </div>

          <div class ="form-group">
              <label for="phone">Phone Number</label>
              <input type="text" class = "form-control" name="phone" id="phone" placeholder="Enter your phone number" 
                  value="<?php echo $user_info[0]['phone_num'];?>">
              <small id="Phone number help" class="form-text text-muted">Please enter a 10 digit phone number</small>
              <span class="error_message" id="msg_phone"></span>                        
          </div>
          
          <div>
            <span class="error_message" id="overall"></span>
          </div>
          
          <button type="submit" class="btn btn-secondary">Submit</button>
          
        </form>

        <br/>
        <div class="form-row">
            <div class="form-group col-md-6">
                <a class="btn btn-danger" href="password.php">Change Password</a>
            </div>
            <div class="form-group col-md-6">
                <a class="btn btn-primary" href="home.php">Cancel</a>
            </div>
        </div>
    </div>
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

<script>
  // checking that the phonenumber is a string
  function isInt(str)
  {
    var val = parseInt(str);
    return (val > 0);
  }
  // checking that the email is an email
  function isEmail(str)
  {
    var re = /\S+@\S+\.\S+/;
    var match_test = re.test(str);
    return match_test;
  }

  //making sure that all elements are filled out
  function checkRegistration()
  {
    var username = document.getElementById("username1").value;
    var first = document.getElementById("first_name").value;
    var last = document.getElementById("last_name").value;
    var email = document.getElementById("Email1").value;
    var phone = document.getElementById("phone").value;
    var errors = 0; 
    
    if (first == "" || last == "")
    {
      errors++;
      document.getElementById("msg_name").innerHTML = "Your firstname or lastname cannot be empty";      
    }

    if ( !isEmail(email))
    {
      errors++;
      document.getElementById("msg_email").innerHTML = "Please enter a valid email address";
    }
    else 
    {
      document.getElementById("msg_email").innerHTML = "";
    }
       
    if ( !isInt(phone))
    {
      errors++;
      document.getElementById("msg_phone").innerHTML = "Your phone is not an integer or it is blank";
    }
    else 
    {
      document.getElementById("msg_phone").innerHTML = "";
    }

    if (errors > 0)
    {
      document.getElementById("overall").innerHTML = "Please fix the errors and then resubmit";
      return false;
    }
    else
    {
      document.getElementById("overall").innerHTML = "";
      return true;
    }  
  }

  </script>