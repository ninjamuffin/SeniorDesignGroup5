<!--form for changing a user's password using the old password to verify -->
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
                if((((!empty($_POST['username']) && !empty($_POST['password'])) && !empty($_POST['password_verify'])) && !empty($_POST['email'])) && !empty($_POST['new_password']))
                {
                    $username = $_POST['username'];
                    $password = md5($_POST['password'] . $salt);
                    $password_verify = md5($_POST['password_verify'] . $salt);
                    $email = $_POST['email'];
                    $new_password = md5($_POST['new_password'] . $salt);
                    
                    $login_sql = "SELECT * FROM SiteUsers WHERE username = ?";
                    
                    $params = array($username);
                    $options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
                    
                    $checkusername = sqlsrv_query($con, $login_sql, $params, $options);
                    
                    if(sqlsrv_num_rows($checkusername) != 1)
                    {
                        echo "<h1>Error</h1>";
                        echo "<p>That username does not appear to be registered, please try again.</p>";
                    }
                    else
                    {
                        if($password != $password_verify)
                        {
                            echo "<h1>Error</h1>";
                            echo "<p>The password and verify password fields do not match. Please try again.";
                        }
                        else
                        {
                         $params = array($new_password, $username, $password);
                         $changepassquery = sqlsrv_query($con, "UPDATE SiteUsers SET password = ? WHERE username = ? AND password = ?", $params, $options);
                        
                            if($changepassquery)
                            {
                                echo "<h1>Success</h1>";
                                echo "<p>Your password was changed successfully. <a href=\"index.php\">Click here to login</a>.</p>";
                            }
                            else
                            {
                                echo "<h1>Error</h1>";
                                echo "<p>The password change failed. <a href =\"changepassword.php\">Please verify your information and try again.</a></p>";
                            }
                        }
                    }
                }
                else
                {
                    ?>        
                    <h1>Want to change your password?</h1>
                    <form method="post" action="changepassword.php" name="changepassword" id="changepassword">
                    <fieldset>
                        <label for="username">Username:</label><input type="text" name="username" id="username" /><br />
                        <label for="email">Email Address:</label><input type="text" name="email" id="email" /><br />
                        <label for="password">Old Password:</label><input type="password" name="password" id="password" /><br />
                        <label for="password_verify">Verify Old Password:</label><input type="password" name="password_verify" id="password_verify" /><br />
                        <label for="new_password">New Password:</label><input type="password" name="new_password" id="new_password" /><br />
                        <input type="submit" name="changepassword" id="changepassword" id="changepassword" value="change Password" />
                        <!--maybe change these to bootstrap things? esp. the verify password field -->
                    </fieldset>
                    </form>         
                    <?php
                }
            ?>
        </div>
    </body>
</html>