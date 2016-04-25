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
        if ($_SESSION['Role'] == 'Admin')
        {
            ?>
            <meta http-equiv='refresh' content='0;/Admin/Home/' />
            <?php
        }
        elseif ($_SESSION['Role'] == 'Student')
        {
            ?>
            <meta http-equiv='refresh' content='0;/Student/Home/' />
            <?php
        }
        elseif ($_SESSION['Role'] == 'Teacher')
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
        $password = md5($_POST['password'] . $salt);
        $loginquery = "
SELECT DISTINCT SU.[user_id], SU.[username], SU.[password], SU.[date_added], R.[Role], R.[Type], R.[Designation], SU.firstname, SU.lastname
FROM SiteUsers as SU, RoleInstances as RI, Roles as R
WHERE SU.username = ? AND
      SU.[password] = ? AND
      RI.SiteUsername = SU.username AND
      RI.Priority = 'Default' AND
      R.RoleID = RI.RoleID";
        
        $params = array($username, $password, $username);
        $options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
        
        $checklogin = sqlsrv_query($con, $loginquery, $params, $options);
        
        
        if(sqlsrv_num_rows($checklogin) == 1)
        {
            $row = sqlsrv_fetch_array($checklogin);
            $role = $row['Role'];
            
            
            $_SESSION['Username'] = $username;
            $_SESSION['LoggedIn'] = 1;
            $_SESSION['Role'] = $role;
            $_SESSION['AccessType'] = $row['Type'];
            $_SESSION['Designation'] = $row['Designation'];
            $_SESSION['UserID'] = $row['user_id'];
            $_SESSION['firstname'] = $row['firstname'];
            $_SESSION['lastname'] = $row['lastname'];
            
            if ($role == 'Admin')
            {
                $params = array($username);
                $options = array( "Scrollable" => 'static');
                $query = "SELECT A.FirstName, A.LastName, A.Email, I.InstitutionName FROM Administrators as A, Institutions as I WHERE A.SiteUsername = ? AND I.InstitutionID = A.InstitutionID";
                $stmt = sqlsrv_query($con, $query, $params, $options);
                if ($stmt === false)
                    die( print_r( sqlsrv_errors(), true));
                if (sqlsrv_fetch($stmt) === true)
                {
                    $first_name = sqlsrv_get_field( $stmt, 0);
                    $last_name = sqlsrv_get_field( $stmt, 1);
                    $email = sqlsrv_get_field( $stmt, 2);
                    $institution = sqlsrv_get_field( $stmt, 3);
                    $_SESSION['Institution'] = $institution;
                }
                
            }
            elseif ($role == 'Teacher')
            {
                $params = array($username);
                $options = array( "Scrollable" => 'static');
                $query = "SELECT FirstName, LastName, Email FROM Teachers WHERE SiteUsername = ?";
                $stmt = sqlsrv_query($con, $query, $params, $options);
                if ($stmt === false)
                    die( print_r( sqlsrv_errors(), true));
                if (sqlsrv_fetch($stmt) === true)
                {
                    $first_name = sqlsrv_get_field( $stmt, 0);
                    $last_name = sqlsrv_get_field( $stmt, 1);
                    $email = sqlsrv_get_field( $stmt, 2);
                }
                else
                    echo "Teacher.";
            }
            elseif ($role == 'Student')
            {
                $params = array($username);
                $options = array( "Scrollable" => 'static');
                $query = "SELECT S.FirstName, S.LastName, S.Email, I.InstitutionName FROM Students as S, Institutions as I WHERE SiteUsername = ? and I.InstitutionID = S.InstitutionID";
                $stmt = sqlsrv_query($con, $query, $params, $options);
                if ($stmt === false)
                    die( print_r( sqlsrv_errors(), true));
                if (sqlsrv_fetch($stmt) === true)
                {
                    $first_name = sqlsrv_get_field( $stmt, 0);
                    $last_name = sqlsrv_get_field( $stmt, 1);
                    $email = sqlsrv_get_field( $stmt, 2);
                    $institution = sqlsrv_get_field( $stmt, 3);
                    $_SESSION['Institution'] = $institution;
                }

            }
            
            $_SESSION['EmailAddress'] = $email;
            $_SESSION['FirstName'] = $first_name;
            $_SESSION['LastName'] = $last_name;
            
            
            
            echo "<meta http-equiv='refresh' content='0;/$role/Home/' />";
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
               <!-- <h4 class="form-signin-heading text-right"><a href="register.php">Register</a></h4> -->
                </form>
            </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
    </body>
    <?php
    }
    ?>
</html>
