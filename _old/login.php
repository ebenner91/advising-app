<?php
    //Start a new session with the server
    session_start();

    //If the authentication session variable does not exist, create it
    if(!isset($_SESSION['auth'])){
        $_SESSION['auth'] = false;
    }
?>


<?php include "dependancies/php/header.php";?>
<!--
/*
* Login
* Author: Stephen King
* Version 2016.4.4.1
*
* This constructs the login window and performs login verification.
*/
-->



        <!--Background Image-->

        <body class="background-container background-student1">

            <!--nav bar and social media-->
            <?php include "dependancies/php/nav.php";?>

                <br>
                <!--Main Content-->

                <div class="col-md-4 col-md-offset-4 container-fluid">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="title-text">Administrative Login</p>
                        </div>

                        <!-- Login Form -->
                    <div class="login">

                    <!--<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">-->
<?php
    /*
    *Database verification
    *This verifies whether a user's credentials are in the database or not.
    */

    require "dependancies/db/dbcon.php";
    require "dependancies/models/LoginModel.php";

    $username = "";
                        
    if(isset($_POST['login'])){

        //store username for sticky form
        $username = $_POST['username'];

        //Create a database connection
        $db = loginDatabase();

        //Create a new VerifyModel object with the database connection
        $loginModel = new LoginModel($db);

        //retrieve the username and password. Run them through checkCredentials to see if
        //there is a match in the database.
        $access = $loginModel->verifyCredentials($username, $_POST['password']);

        //If the result is true, allow login. Otherwise block it.
        if($access){
            $_SESSION['auth'] = true;
            //redirect to the homepage after login
            echo '<script>window.location = "admin.php";</script>';
        }else{
            //Inform the user that they cannot login
            echo 'Incorrect Username or Password';
        }

        //Terminate database connection
        $db = null;
    }
?>
    <!--Login Form-->
    <form method="post" action=" <?php $_SERVER['PHP_SELF']; ?>">
        <!--Username-->
        <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" placeholder="username" required>
        <br>
        <!--Password-->
        <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
        <br>
        <!--Submit Button-->
        <input type="submit" class="btn btn-info" id="login-btn" name="login" value="Login">
    </form>
            <!--End Login Form-->            
            </div>
        <!--End Panel-->
        </div>
    <!--End Container-->
    </div>

<!--Footer-->
<?php include "dependancies/php/footer.php";?>