<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="support-css/support-ticket-search.css">
    <link rel="stylesheet" href="support-css/nav_side.css">
    <title>Search Open Tickets</title>
</head>
<body>
    <div class="navigation-bar">
        
        <div class="left-side">
            <img class="epic-games-logo" src="images\Epic_Games_logo.svg.webp">
            <p class="epic-games-text">Epic Games Support</p>
        </div>
        <div>
            <a href="support-logout.php" class="logout-link">Logout</a>
        </div>
    </div>

    <div class="side-bar">
    </div>
        <?php
            include 'db.inc.php';

            $mysql = "SELECT * FROM Ticket WHERE (tstatus) = ('Open') OR (tstatus) = ('Elevated') "; //only prints out opened or elevated tickets

            if(!$result = mysqli_query($con, $mysql))
                {
                    echo "There has been an error with your query" . mysqli_error($con);
                }
            else
                {
                    $affectedrows = mysqli_affected_rows($con);
                        if($affectedrows < 1) //if there arent any tickets
                            {
                                echo 
                                "
                                    <div class='no-tickets'>
                                        <p>There is currently no open tickets, come back later.</p>
                                    </div>
                                ";
                            }
                        else
                            {
                                echo "<table>
                                    <tr>
                                        <th>User Id</th><th>Ticket Id</th><th>Subject</th><th>Information</th><th>Severity</th><th>Date of Submit</th><th>Status</th>
                                    </tr>";
                                    
                                    while($TicketTableRow = mysqli_fetch_array($result))
                                        {
                                            $userID = $TicketTableRow['tuid'];
                                            $ticketID = $TicketTableRow['tid']; //creates a session variable so that we can call it for the elavation
                                            $ticketSubject = $TicketTableRow['tsubject'];
                                            $ticketInfo = $TicketTableRow['tinfo'];
                                            $ticketSeverity = $TicketTableRow['tseverity'];
                                            $ticketDOS = $TicketTableRow['tdos'];
                                            $ticketStatus = $TicketTableRow['tstatus'];

                                            echo "
                                            <tr>
                                            <form action='support-resolve-or-elevate.php' method='POST'>

                                            ";
                                            if($_SESSION['Apriviledge'] == 2) //if a user with a lower priviledge logs in
                                                {
                                                    if($ticketStatus != "Elevated") //the user can't see elavated tickets
                                                        {
                                                            echo"
                                                                <td>$userID</td> 
                                                                <td>$ticketID</td> 
                                                                <td>$ticketSubject</td> 
                                                                <td>$ticketInfo</td>
                                                                <td>$ticketSeverity</td> 
                                                                <td>$ticketDOS</td> 
                                                                <td>$ticketStatus</td>
                                                                

                                                                <input type='hidden' name='uid' value='$userID'>
                                                                <input type='hidden' name='tid' value='$ticketID'>
                                                                <input type='hidden' name='tsubject' value='$ticketSubject'>
                                                                <input type='hidden' name='tinfo' value='$ticketInfo'>
                                                                <input type='hidden' name='tseverity' value='$ticketSeverity'>
                                                                <input type='hidden' name='tdos' value='$ticketDOS'>
                                                                <input type='hidden' name='tstatus' value='$ticketStatus'>
                                                                <input type='hidden' name='tstatus' value='$ticketStatus'>

                                                                <td><button type='submit' name='tsubmission' value='Resolve' class='resolve'>Resolve</button></td>
                                                                
                                                                <td><button type='submit' name='tsubmission' value='Elevate' class='elavate'>Elevate</button></td>
                                                                  
                                                            </form>
                                                            </tr>
                                                        ";//used AI for the input hidden part 
                                                        }
                                                }
                                            else //if a user with a higher priviledge logs in
                                                {
                                                    echo"
                                                        <td>$userID</td> 
                                                        <td>$ticketID</td> 
                                                        <td>$ticketSubject</td> 
                                                        <td>$ticketInfo</td>
                                                        <td>$ticketSeverity</td> 
                                                        <td>$ticketDOS</td> 
                                                        <td>$ticketStatus</td>
                                                        

                                                        <input type='hidden' name='uid' value='$userID'> 
                                                        <input type='hidden' name='tid' value='$TicketTableRow[tid]'>
                                                        <input type='hidden' name='tsubject' value='$ticketSubject'>
                                                        <input type='hidden' name='tinfo' value='$ticketInfo'>
                                                        <input type='hidden' name='tseverity' value='$ticketSeverity'>
                                                        <input type='hidden' name='tdos' value='$ticketDOS'>
                                                        <input type='hidden' name='tstatus' value='$ticketStatus'>
                                                        <input type='hidden' name='tsubmission' id='ticket-submission'>

                                                        <td><button type='submit' name='tsubmission' value='Resolve' class='resolve'>Resolve</button></td>
                                                         
                                                        </form>
                                                    </tr>
                                                ";//used AI for the input hidden part 
                                                }
                                        }
                            }
                }
    ?>
</body>
</html>