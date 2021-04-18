<?php session_start(); ?>

<link href="./styles/navbar.css" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<header class="header">
    <nav class="navbar navbar-expand-md navbar-dark" style="background-color: #2f4962;">
        <img class="paw" src="https://pngimg.com/uploads/paw/paw_PNG21.png" height="80vw">
        <title class="navbar-brand" href="home.php" style= "font-size:45px">Purrfect Pets</title>
        <style type="text/css">
            h1	{font-family: 'Rubik', Arial;
                }
            a {font-family: 'Rubik', Arial;
            }
            title {font-family: 'Rubik', Arial;
            }
        </style>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="justify-content-end" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pets.php">Pets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="favorites.php">Favorites</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="settings.php">Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact Us</a>
                </li>
                <!-- LOG IN BUTTON, REDIRECTS TO LOGIN PAGE -->
                <?php
                //checks to see if user is logged in
                    if (!isset($_SESSION['user'])){

                ?>
                <li class="nav-item">
                    <a class="nav-link login" href="login.php"
                        style=" color: black; background-color: lightblue; 
              border-radius: 10px; width: 8vw; text-align: center; border-color: black; border-width: 1px; border-style: solid;">Log In!</a>
                </li>
                <?php 
                    }
                    else
                    {
                ?>
                <li class="nav-item">
                    <a class="nav-link logout" href="logout.php"
                        style=" color: black; background-color: lightblue; 
              border-radius: 10px; width: 8vw; text-align: center; border-color: black; border-width: 1px; border-style: solid;">Log Out</a>

                <?php }?>
            </ul>
        </div>

    </nav>
</header>