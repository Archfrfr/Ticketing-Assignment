<?php

include 'db.inc.php';

    
    $mysql = "UPDATE Ticket SET tresolution = '$_POST[solution]', tstatus = 'Resolved' WHERE (tid) = ('$_POST[tid]')"; //changes the ticket status to resolved

        if(!$result = mysqli_query($con, $mysql))
                {
                    echo "There has been an error with your query" . mysqli_error($con);
                }
        else
            {
                include 'support-search.php';
            }
?>