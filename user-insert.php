<?php
 session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Insert</title>
    <link rel="stylesheet" href="user-css\user-open-ticket.css">
    <link rel="stylesheet" href="user-css\nav_sidebar.css">
</head>
<body>
    <?php
        include 'db.inc.php';//includes the connection to mysql

        $mysql1 = "SELECT Uid FROM User WHERE (uname) = ('$_SESSION[user]')"; //to get the id of the user that made the ticket


        if(!$result = mysqli_query($con, $mysql1))//query gets loaded into mysql
            {
                echo "There has been an error" . mysqli_error($con);//if there is an error
                
            }
        else
            {
                $row = mysqli_fetch_array($result);
                $userId = $row['Uid'];
                $date = date_create();
                $date = date_format($date, "Y-m-d");

                $mysql2 = "INSERT into Ticket (tuid, tsubject, tinfo, tseverity, tdos) VALUES('$userId','$_POST[subject]','$_POST[reason]','$_POST[severity]', '$date')";
                if(!mysqli_query($con, $mysql2))//query gets loaded into mysql
                    {
                        echo "There has been an error" . mysqli_error($con);//if there is an error
                    }
            }

        mysqli_close ($con);//closes mysql

        include 'user-ticket-open.html';
    ?>
</body>
</html>