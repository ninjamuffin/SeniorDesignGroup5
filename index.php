<?php include "base.php"; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Gonzaga Small Talk</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet">
    
        <!-- Header File -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <style>
            body{
                background: url(Media/GonzagaBackground.jpg) no-repeat center center fixed;
                    -webkit-background-size: cover;
                    -moz-background-size: cover;
                    -o-background-size: cover;
                    background-size: auto;
                
            }
            a{
                color:white;
                text-decoration: underline;
            }
        </style>
    </head>
    
    <?php
    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
    {
        // let the user access the main page
        if ($_SESSION['Role'] == 'admin')
        {
            ?>
            <meta http-equiv='refresh' content='0;/Admin/Home/' />
            <?php
        }
        elseif ($_SESSION['Role'] == 'student')
        {
            ?>
            <meta http-equiv='refresh' content='0;/Student/Home/' />
            <?php
        }
        elseif ($_SESSION['Role'] == 'teacher')
        {
            ?>
            <meta http-equiv='refresh' content='0;/Teacher/Home/' />
            <?php
        }
        ?>
        <?php
        /*
        <h1>Gonzaga Smalltalk</h1>
        <p>You are currently logged in as <code><?=$_SESSION['Username']?></code> your email: <code><?=$_SESSION['EmailAddress']?></code>. Redirecting to your home page</p>
        
        
        <a href="logout.php">Logout</a>
        */
        ?>
        <?php
    }
    elseif(!empty($_POST['username']) && !empty($_POST['password']))
    {
        // let the user login //mssql_escape may cause problems with md5()
        $username = $_POST['username'];
        $password = md5($_POST['password'] + $salt);
        $loginquery = "SELECT * FROM SiteUsers WHERE username = ? AND password = ?";
        
        $params = array($username, $password);
        $options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
        
        $checklogin = sqlsrv_query($con, $loginquery, $params, $options);
        
        
        if(sqlsrv_num_rows($checklogin) == 1)
        {
            $row = sqlsrv_fetch_array($checklogin);
            $email = $row['email'];
            $role = $row['role'];
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            
            
            $_SESSION['Username'] = $username;
            $_SESSION['EmailAddress'] = $email;
            $_SESSION['FirstName'] = $first_name;
            $_SESSION['LastName'] = $last_name;
            
            $_SESSION['LoggedIn'] = 1;
            $_SESSION['Role'] = $role;
            
            echo "<meta http-equiv='refresh' content='0;/' />";
        }
        else
        {?>
            <body>
                <div class ="well col-xs-12">
                    <h1 class="form-signin-heading text-right"><font color="white">Error</font></h1>
                    <p><font color="white">Sorry, your account could not be found</font></p>
                    <p><font color="white">Please <a href="/">click here to try again</a></font></p>
                    <p><font color="white">If you are having trouble accessing your account, contact your administrator</font></p>
                </div>    
            
            </body>
        <?php
           
    
        }
    }
    else
    {
        // display the login form
        ?>
    
        <!-- <body background="GonzagaBackground.jpg"> -->
        <body>
            <div class="well col-xs-12 pull-right">
                <form class="form-signin" method ="post" action="/" name="loginform" id="loginform">
                <h1 class="form-signin-heading text-right"><font color="white">Sign-in</font></h1>
                    <!--<h4 class="form-signin-heading text-right"><font color="white">Login below or <a href= "register.php">click here to register</a>.</font></h4>-->
                    
                <fieldset>
                    <label for="username" class="sr-only">Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required="" autofocus"">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required="">
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                </fieldset>
                <h4 class="form-signin-heading text-right"><a href="#">Forgot Username?</a></h4>
                <h4 class="form-signin-heading text-right"><a href="#">Forgot Password?</a></h4>
                <h4 class="form-signin-heading text-right"><a href="register.php">Register</a></h4>
                </form>
            </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
    </body>
    <?php
    }
    ?>
</html>
