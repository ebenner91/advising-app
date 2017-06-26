<?php
    //Start a new session with the server
    session_start();
   
   //De-Authenticate user
    $_SESSION['auth'] = false;
    echo '<script>window.location = "../../index.php";</script>';
	
	?>