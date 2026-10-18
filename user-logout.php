<?php 
    session_start();
    if(isset($_SESSION['user']))
        {
            session_destroy();
            include 'user-login.php';
        }
?>
