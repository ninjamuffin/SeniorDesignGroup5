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
                if(!empty($_POST['email']))
                {
                    $email = $_POST['email'];
                    
                        $subject = "Gonzaga Smalltalk ELC Password Reset";
                        $message = "<html>
                            <head>
                            <title>Password Reset</title>
                            </head>
                            <body>
                            <p>This email has been sent because you requested to have your password reset on the Gonzaga Smalltalk site. If you did not request to have your password changed, please disregard and delete this email.</p>
                            <p>Link to password reset form</p>
                            </body>
                            </html>";
                        $headers  = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $headers .= 'To: ' . $email . "\r\n";
                        $headers .= 'From: passwordreset@gonzagasmalltalk.azurewebsites.net' . "\r\n";
                        if(mail($email, $subject, $message, $headers))
                        {
                            echo "<h1>Reset Email Sent</h1>";
                            echo "<p>A confirmation email has been sent to " . $email . ".  Please follow the instructions in the email to reset your password.</p>";
                        }
                        else
                        {
                            echo "<h1>Email Failed</h1>";
                            echo "<p>The confirmation email failed to send. <a href=\"sendemailtest.php\">Please try again</a>.</p>";
                        }
                }
                else
                {
                    ?>             
                    <h1>Forgot Your Password?</h1>
                    <p>Please enter your email address.  An email will be sent with a link to reset your password.</p>
                    <form method="post" action="sendemailtest.php" name="resetform" id="resetform">
                    <fieldset>
                        <label for="email">Email Address:</label><input type="text" name="email" id="email" /><br />
                        <input type="submit" name="reset" id="reset" id="reset" value="Send Email" />
                    </fieldset>
                    </form>         
                    <?php
                }
            ?>
        </div>
    </body>
</html>