<?php include "base.php"; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Bootstrap 101 Template</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet">
        
        <!-- Header File -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script>
            $(function(){
                $("#header").load("header.html");
            });
        </script>
        <style>
            body{
                background: url(Media/GonzagaBackground.jpg) no-repeat center center fixed;
                    -webkit-background-size: cover;
                    -moz-background-size: cover;
                    -o-background-size: cover;
                    background-size: auto;
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
            <meta http-equiv='refresh' content='0;/Admin/Home/index.php' />
            <?php
        }
        ?>
        <h1>Gonzaga Smalltalk</h1>
    <p>You are currently logged in as <code><?=$_SESSION['Username']?></code> your email: <code><?=$_SESSION['EmailAddress']?></code>. Redirecting to your home page</p>
    
    
    <a href="logout.php">Logout</a>
    
        <?php
    }
    elseif(!empty($_POST['username']) && !empty($_POST['password']))
    {
        // let the user login //mssql_escape may cause problems with md5()
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $loginquery = "SELECT * FROM SiteUsers WHERE username = '". $username."' AND password = '". $password."'";
        
        $params = array();
        $options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
        
        $checklogin = sqlsrv_query($con, $loginquery, $params, $options);
        
        
        if(sqlsrv_num_rows($checklogin) == 1) // ==1
        {
            $row = sqlsrv_fetch_array($checklogin);
            $email = $row['email'];
            $role = $row['role'];
            
            $_SESSION['Username'] = $username;
            $_SESSION['EmailAddress'] = $email;
            $_SESSION['LoggedIn'] = 1;
            $_SESSION['Role'] = $role;
            
            echo "<h1>Success</h1>";
            echo "<p>redirecting...</p>";
            echo "<meta http-equiv='refresh' content='2;index.php' />";
        }
        else
        {
            echo "<h1>Error</h1>";
            echo "<p>Sorry, your account could not be found. Please <a href=\"index.php\">click here to try again</a>.</p>";
        }
    }
    else
    {
        // display the login form
        ?>
    
        <!-- <body background="GonzagaBackground.jpg"> -->
        <body>
            <div class="well col-xs-12 pull-right">
                <form class="form-signin" method ="post" action="index.php" name="loginform" id="loginform">
                <h1 class="form-signin-heading text-right"><font color="white">Sign-in</font></h1>

                    <h4 class="form-signin-heading text-right"><font color="white">Login below or <a href= "register.php">click here to register</a>.</font></h4>

                

                <fieldset>
                    <label for="username" class="sr-only">Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required="" autofocus"">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required="">
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                </fieldset>
                </form>
            </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap-datepicker.js"></script>
    </body>
        <?php
    }
    ?>
</html>

<!-- old sign in form for reference
    <body background="GonzagaBackground.jpg">
        <div class="jumbotron">
            <div class="well">
                <div class="container">
                    <div class="col-xs-10 col-md-6 col-lg-8" >
                        <form class="form-signin">
                            <h2 class="form-signin-heading">Sign-in</h2>
                            <label for="inputEmail" class="sr-only">Email address</label>
                            <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
                            <label for="inputPassword" class="sr-only">Password</label>
                            <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" value="remember-me"> Remember me
                              </label>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <button class="btn btn-lg btn-primary btn-block" type="submit" href="TeacherHome.html">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
/-->
