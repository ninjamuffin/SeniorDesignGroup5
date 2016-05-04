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
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script>
            $(function(){
                $("#header").load("header.html");
            });
        </script>
    </head>
    
    <body>
        <div id="main">
            <?php
                if(!empty($_POST['username']) && !empty($_POST['password']))
                {
                    $username = $_POST['username'];
                    $password = md5($_POST['password'] . $salt);
                    $firstname = $_POST['firstname'];
                    $lastname = $_POST['lastname'];
                    
                    
                    $login_sql = "SELECT * FROM SiteUsers WHERE username = ?";
                    
                    $params = array($username);
                    $options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
                    
                    $checkusername = sqlsrv_query($con, $login_sql, $params, $options);
                    
                    if(sqlsrv_num_rows($checkusername) == 1)
                    {
                        echo "<h1>Error</h1>";
                        echo "<p>That username is already registered.</p>";
                    }
                    else
                    {
                        $params = array($username, $password, $firstname, $lastname);
                        $registerquery = sqlsrv_query($con, "INSERT INTO SiteUsers (username, password, firstname, lastname, date_added) VALUES(?,?,?,?, GETDATE())", $params, $options);
                        
                        if($registerquery === false)
                        {
                            echo "<h1>Error</h1>";
                            echo "<p>Registration failed. <a href =\"register.php\">Please try again.</a></p>";
                        }
                        else
                        {
                            echo "<h1>Success</h1>";
                            echo "<p>Your account was successfully created. <a href=\"index.php\">Click here to login</a>.</p>";
                        }
                      
                    }
                }
                else
                {
                    ?>
                    
                    <h1>Register</h1>
                    <p>Please enter your details below to register.</p>
                    <form method="post" action="register.php" name="registerform" id="registerform">
                    <fieldset>
                        <label for="firstname">First Name:</label><input type="text" name="firstname" id="firstname" /><br />
                        <label for="lastname">Last Name:</label><input type="text" name="lastname" id="lastname" /><br />
                        <label for="username">Username:</label><input type="text" name="username" id="username" /><br />
                        
                        <label for="password">Password:</label><input type="password" name="password" id="password" /><br />
                        
                        <!--<select name="role" id="role">
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                        <option value="admin">Administrator</option><br />
                        </select>-->
                        <input type="submit" name="register" id="register" id="register" value="Register" />
                    </fieldset>
                    </form>         
                    <?php
                }
            ?>
        </div>
    </body>
</html>