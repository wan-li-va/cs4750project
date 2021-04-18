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
    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap" rel="stylesheet">
    <!-- ICON  -->
    <link rel="shortcut icon" href="https://media2.giphy.com/media/n9wqJ8gTR9lQnXTvf3/giphy_s.gif" type="image/ico" />
    <!-- EXTERNAL CSS -->
    <link href="./styles/style.css" rel="stylesheet" type="text/css" />
</head>

<?php include "./navbar.php";
    // checks that the user is logged in
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {

            $query = "SELECT * FROM donors ORDER BY shelter_name";
                $statement = $db->prepare($query);
                $statement->execute();
                    
                // fetchAll() returns an array for all of the rows in the result set
                $user_info = $statement->fetchAll();
                    
                // closes the cursor and frees the connection to the server so other SQL statements may be issued
                $statement->closecursor();

        }
        else if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if (!empty($_POST['action']) && ($_POST['action'] == 'Update'))
            {
                $_SESSION['id'] = $_POST['username'];
                header("Location: managerChange.php");

            }
        }
    ?>
    <body>
    <div class="sketchy">
        <center><h1 class="title">List of Donors</h1>
        <a>Thank you to everyone who has contributed to our causes. If you are interested in donating to a shelter, please <a href="contact.php">contact us</a>.</a></center>
    </div>
    <div class="table-responsive">
        <!-- Make it striped -->
        <table class="table table-striped table-bordered" style="width:100%" id = "users">
            <!-- Defining the different columns -->
            <colgroup>
                <col class="table1">
                <col class="table2">
                <col class="table3">
                <col class="table4">
              </colgroup>
            <!-- Header for the columns -->
            <tr class="thead">
                <th>First Name</th>
                <th>Last Name</th>
                <th>Donation Amount</th>
                <th>Shelter Name</th>
            </tr>
            <?php foreach ($user_info as $g): ?>
            <tr>
                <td>
                    <?php echo $g['first_name']; // refer to column name in the table ?> 
                </td>
                <td>
                    <?php echo $g['last_name']; ?> 
                </td>        
                <td>
                    <?php echo $g['donation_amt']; ?> 
                </td>
                <td>
                    <?php echo $g['shelter_name']; ?> 
                </td>                                                     
            </tr>
            <?php endforeach; ?>

        </table>

    </body>