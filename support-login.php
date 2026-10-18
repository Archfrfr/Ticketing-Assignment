<?php
    session_start();
?>
<html lang="en">
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="support-css\login.css">
</head>
<body>
    <?php 
        include 'db.inc.php';

        //NOT ON LOAD
        if (isset($_POST['loginName']) && isset($_POST['passWord']))//Checks if the following has values
            {
                $attempts = $_SESSION['attempts'];
            
                $sql = "SELECT * FROM Agent WHERE Ausername = '$_POST[loginName]' AND Apass = '$_POST[passWord]'";//selects the selected name and password from the database

                if (!$result = mysqli_query($con, $sql))//if there is an error in the query
                    {
                        echo "Error in query ". mysqli_error($con);
                    }
                else //if there isnt
                    {
                        if(mysqli_affected_rows($con) == 0)//if the logins are wrong
                            {
                                $attempts++;//attempt counter goes up

                                if($attempts <= 3)//if there is less than 3 attempts
                                    {
                                        $_SESSION['attempts'] = $attempts;//overwrites
                                        buildPage($attempts);//calls the function to make a page again
                                        //error message
                                        echo "<div class='errorstyle'>No record found with this login name and password combination - Please try again .</div>";
                                    }
                                else//if there is more than 3 attempts
                                    {
                                        //error message 
                                        echo "<div class='error'>Sorry - You have used all 3 attempts <br> Shutting down ...</div>";
                                    }
                            }
                            
                        else//Sucessful login
                            {
                                $_SESSION['user'] = $_POST['loginName']; //Session Variable to keep track of the login name
                                $TicketTableRow = mysqli_fetch_array($result);
                                $_SESSION['Apriviledge'] = $TicketTableRow['Apriviledge'];
                                //This is done so you can use the loginName for the change password screen
                                ?>
                                <script>
                                    window.location.href = "support-search.php"; //THIS IS AI HELP TO PREVENT SESSION ISSUES instead of, include 'support-search.php', 
                                    //when i tried to go back to the support-search page from the resolve screen it would tell me that 'Apriviledge' is not found because the session wasnt enabled 
                                    // but if i had a session enabled it would give me another error
                                </script>
                                <?php
                            }
                    }
            }
        else //ON LOAD
            {
                // building page for initial display
                $attempts = 1; //Screen will be displayed for first attempt
                $_SESSION['attempts'] = $attempts;  //set session variables so that the number of attempts can be counted
                buildPage($attempts); // parameter passed so that a heading can display the number of attempts
            }
            function buildPage($att)//function that creates the base form
                {
                    echo //creates a form

                        "<form action='support-login.php' method='post'>
                            <img class='support-image'src='images\support.avif'>
                            <img class='epic-games' src='images\Epic_Games_logo.svg.webp'>

                            <div class='Sign-in'>
                                Staff Sign in
                            </div>
                            
                            <div class='credentials'>
                                <div class='username'>
                                    <input type ='text' required class='uname-input' name ='loginName'  placeholder='Username' pattern='[a-zA-Z0-9 ]+'/>
                                </div>
                                    
                                <div class='password'>
                                    <input type='password' required class='pass-input' name ='passWord' placeholder='Password' pattern='[A-Za-z0-9]+'>
                                </div> 
                            </div>

                            <div class='submit-creds'>
                                <input type='submit' class='submit' value='Login'>
                            </div>
                            <div class='back'>
                                <a href='index.html' class='link'> Back to menu </a>
                            </div 
                        </form>";  
                }
        mysqli_close($con);
    ?>
</body>
</html>