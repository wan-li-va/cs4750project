<html>
  <?php 
    require('connect-db.php');
  ?>

  <style>
    .error_message {  color: crimson; font-style:italic; }       
  </style>

    <head>
    
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="author" content="Alan Zhai">
    <meta name="description" content="Account Creation">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="../styles/account_create.css">  -->
    
</head>

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
            $statement->bindValue(':password', $pass);
            $statement->execute();
            $statement->closeCursor();

            
        }  

    }     
   
   ?>
    <div class="container" style="text-align: center;">

          <!-- one of the columns in the container -->
          <!-- the sign up column -->
                <h3>
                    Sign Up
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

  </div>

  <!-- type checking and form validation using javascript -->
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
    var pass1 = document.getElementById("pass1").value;
    var pass2 = document.getElementById("pass2").value;
    var first = document.getElementById("first_name").value;
    var last = document.getElementById("last_name").value;
    var email = document.getElementById("Email1").value;
    var phone = document.getElementById("phone").value;
    var errors = 0; 

    if (username == "")
    {
      errors++;
      document.getElementById("msg_user").innerHTML = "Please enter a valid username";
    }
    else 
    {
      document.getElementById("msg_user").innerHTML = "";
    }

    // //check if passwords match
    if (pass1 == "" || pass2 == "")
    {
      errors++;
      document.getElementById("msg_pass").innerHTML = "Your passwords cannot be empty";      
    }
    else if(pass1 != pass2)
    {
      errors++;
      document.getElementById("msg_pass").innerHTML = "Your passwords must match";
    }
    else 
    {
      document.getElementById("msg_pass").innerHTML = "";
    } 
    
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

</html>