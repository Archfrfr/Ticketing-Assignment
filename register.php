<?php
    include 'db.inc.php';
    
        $mysql = "INSERT into User (Uname, Upass, Uemail, Udob) VALUES ('$_POST[username]','$_POST[passWord]', '$_POST[email]', '$_POST[dob]')"; //adds a user to the data base

        if(!mysqli_query($con, $mysql))
            {
                echo "There has been an error with the query" . mysqli_error($con);
            }
    include 'user-login.php';
?>