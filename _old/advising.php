<?php
    //Start a new session with the server
    session_start();

    //If the authentication session variable does not exist, create it
    if(!isset($_SESSION['auth'])){
        $_SESSION['auth'] = false;
    }
?>

<!--Header Include-->
<?php include "dependancies/php/header.php";?>

<!--Background Image-->
<body class="background-container background-student1">
        
<!--nav bar and social media-->
<?php include "dependancies/php/nav.php";?>

        <br>

<!--Main Body-->

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

<!--Footer-->
<?php include "dependancies/php/footer.php";?>