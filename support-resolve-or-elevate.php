<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="support-css/support_resolve.css">
    <link rel="stylesheet" href="support-css/nav_side.css">
    <script src="support.js"></script>
    <title>Support Resolve</title>
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

        if($_POST['tsubmission'] == "Resolve") //if they clicked resolve, 
        // it prints out a menu where you can resolve the issue
            {
                echo "
                <form action='support-resolve-insert.php' method='POST'>
                    <div class='top'>

                        <div>
                            <p class='T-left'>
                                <label>User ID</label>
                                <input disabled value='$_POST[uid]'>
                            </p>
                            <p class='T-left'>
                                <label>Ticket ID</label>
                                <input disabled id='tid' name='tid' value='$_POST[tid]'>
                            </p>
                            <p class='T-left'>
                                <label>Severity</label>
                                <input disabled value='$_POST[tseverity]'>
                            </p>
                            
                        </div>
                    
                        <div>
                            <p class='T-right'>
                                <label>Status</label>
                                <input disabled value='$_POST[tstatus]'>
                            </p>
                            <p class='T-right'>
                                <label>Date Submitted</label>
                                <input disabled value='$_POST[tdos]'>
                            </p>
                            
                        </div>

                    </div>

                    <div class='middle'>
                        <p class='M-left'>
                            <label class='subject'>Subject</label>
                            <input disabled value='$_POST[tsubject]'>
                        </p>
                        <p class='M-right'>
                            <label class='issue'>Issue</label>
                            <textarea disabled rows='5' cols='30'>$_POST[tinfo]</textarea>
                        </p>
                    </div>

                    <div class='bottom'>
                        <p class='B-inputs'>
                            <label>Solution</label>
                            <textarea class='B-solution' rows='5' name='solution'></textarea>
                        </p>
                    </div>

                    <div class='submit'>
                        <button type='submit' onclick='toggleAmendView()'>Resolve</button>
                    </div>

                    <div class='back'>
                        <a href='support-search.php' class='link'> Cancel </a>
                    </div
                </form>
            ";
            }
        else if($_POST['tsubmission'] == "Elevate")
            {
                $mysql = "UPDATE Ticket SET tstatus = 'Elevated' WHERE (tid) = ('$_POST[tid]')"; //changes the status to elevated

                if(!$result = mysqli_query($con, $mysql))
                        {
                            echo "There has been an error with your query" . mysqli_error($con);
                        }
                else
                    {
                        ?>
                            <script>
                                window.location.href = "support-search.php"; //THIS IS AI HELP TO PREVENT SESSION ISSUES instead of, include 'support-search.php', 
                                            //when i tried to go back to the support-search page from the resolve screen it would tell me that 'Apriviledge' is not found because the session wasnt enabled 
                                            // but if i had a session enabled it would give me another error
                            </script>
                        <?php
                    }
            }
    ?>
</body>
</html>