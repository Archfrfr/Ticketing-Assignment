<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="user-css\close-ticket.css">
    <link rel="stylesheet" href="user-css\nav_sidebar.css">
    <title>User ticket Page</title>
</head>
    <style>
        
    </style>
<body>

    <div class="navigation-bar">
        <div class="left-side">
            <img class="epic-games-logo" src="images\Epic_Games_logo.svg.webp">
            <p class="epic-games-text">Epic Games Support</p>
        </div>
        <div>
            <button><a href="user-logout.php" class="logout-link">Logout</a></button>
        </div>
    </div>

    <div class="side-bar">
        <button class="open-ticket"><a href="user-ticket-open.html">Open Ticket</a></button>
        <button class="view-ticket"><a href="user-ticket-view.php">View Ticket</a></button>
        <button class="close-ticket"><a href="user-ticket-close.php">Close Ticket</a></button>
    </div>
    
    <div class="container">
        <div class="view-title">
            Epic Games Ticket Support
        </div>
        <?php
        include 'db.inc.php';

        $mysql1 = "SELECT * FROM User WHERE (uname) = ('$_SESSION[user]')"; //to get the id of the user that made the ticket

        if(!$result = mysqli_query($con, $mysql1))//query gets loaded into mysql
            {
                echo "There has been an error" . mysqli_error($con);//if there is an error
            }
        else
            {
                $UserTableRow = mysqli_fetch_array($result);
                $userId = $UserTableRow['Uid'];

                $mysql2 = "SELECT * FROM Ticket WHERE (tuid) = ('$userId') AND (tstatus) = ('Resolved')";
                if(!$result = mysqli_query($con, $mysql2))//query gets loaded into mysql
                    {
                        echo "There has been an error" . mysqli_error($con);//if there is an error
                    }
                else
                    {
                        $affectedrows = mysqli_affected_rows($con);
                        if($affectedrows < 1)
                            {
                                echo 
                                "
                                    <div class='no-tickets'>
                                        Your resolved tickets will appear here 
                                        <br>and you will be able to close them.
                                    </div>
                                ";
                            }
                        else
                            {
                                echo 
                                    "
                                    <table class='ticket-table'>
                                        
                                            <tr>
                                                <th>Ticket ID</th> <th>Ticket Info</th> <th>Severity</th> <th>Ticket Status</th>
                                            </tr>
                                    ";
                                while($TicketTableRow = mysqli_fetch_array($result))
                                    {
                                        $_SESSION['ticketID'] = $TicketTableRow['tid'];
                                        $ticketInfo = $TicketTableRow['tinfo'];
                                        $ticketSeverity = $TicketTableRow['tseverity'];
                                        $ticketStatus = $TicketTableRow['tstatus'];
                                        
                                        echo "
                                                <tr>
                                                    <td>$_SESSION[ticketID]</td> <td class='ticket-info'>$ticketInfo</td> <td>$ticketSeverity</td> <td>$ticketStatus</td>
                                                    <td><button class='submit'><a href='close.php'>Close</a></button><td>
                                                </tr>
                                        ";
                                    }
                            }
                    }
            }
    ?>
    </div>
</body>
</html>
