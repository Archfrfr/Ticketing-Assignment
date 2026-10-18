<?php
    session_start();

    include 'db.inc.php';

    $mysql = "UPDATE Ticket SET tstatus = 'Closed' WHERE (tid) = ('$_SESSION[ticketID]')";
    if(!mysqli_query($con, $mysql))
        {
            echo "there has been an error with your query" . mysqli_error($con);
        }
    else
        {
            session_abort(); //gave me a session error when i loaded the user-ticket-close.php file so i had to end the session 
                            //but the session reopens when the page is loaded again
            include 'user-ticket-close.php';
        }
?>