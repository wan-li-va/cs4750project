<?php 
    require("allActions.php");
    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        session_start();
        if (count($_SESSION) > 0) 
        {
            foreach ($_SESSION as $key => $value)
            {
                unset($_SESSION[$key]);
            }     
        session_destroy();
        }
        header('refresh:1; url=home.php');

    }
?>