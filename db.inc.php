<?php
       // hostname is the name of the container
       //username, password & database are set in docker compose
       $con = mysqli_connect('db', 'Artjoms_Bobrovs', 'LdIdskac3472!', 'ArtjomsBobrovsDB');
       if(!$con){
        echo "<p>Error</p>";
       }

    ?>