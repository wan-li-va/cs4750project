<?php session_start(); ?>

<link href="./styles/navbar.css" rel="stylesheet" type="text/css" />

<header class="header">
    <nav class="navbar navbar-expand-md navbar-dark" style="background-color: #2f4962;">
        <img class="paw" src="https://pngimg.com/uploads/paw/paw_PNG21.png" height="80vw">
        <a class="navbar-brand" href="home.php">Purrfect Pets</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="justify-content-end" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="mynotes.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Favorites</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.html">Contact Us</a>
                </li>
                <!-- LOG IN BUTTON, REDIRECTS TO LOGIN PAGE -->
                <?php
                //checks to see if user is logged in
                    if (isset($_SESSION['user'])){

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