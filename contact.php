<!DOCTYPE html>
<html lang="en">

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

<?php include "./navbar.php" ?>

<body>
    <div class="body">
        
    <h1> Send us a question! </h1>
    <div class="form-group" method="POST" action="send_contact.php">
                    <label for="Name">Name</label>
                    <input type="text" class="form-control" id="Name" placeholder="Your name">
                </div>
                <div class="form-group">
                    <label for="Email">Email address</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="Subject">Subject</label>
                    <input type="Subject" class="form-control" id="subject" aria-describedby="emailHelp" placeholder="Subject">
                </div>
                <div class="form-group">
                    <label for="Message">Your Message</label>
                    <textarea class="form-control" id="Message" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-lg">Submit</button>
    </div>
</body>