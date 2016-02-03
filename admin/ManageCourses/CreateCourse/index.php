<?php include "/base.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title> Gonzaga Small Talk</title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/simple-sidebar.css" rel="stylesheet">


    <!-- Including Header -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>
        $(function(){
            $("#header").load("/header.php");
        });
        $(function(){
            $("#sidebar").load("/sidebar.php");
        });
    </script>

    <!-- Background Setup -->
    <style>
        body{
            background: url(/Media/gonzagasmalltalk_background.png) no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: auto;
        }
    </style>
</head>

<?php
session_start();
$dbhost = "o0tvd0xlpb.database.windows.net,1433";
$dbname = "SmalltalkMigrate2.0";
$dbuser = "CS05";
$dbpass = "!1Elcwebapp";
$connectionInfo = array( "Database"=>$dbname, "UID"=>$dbuser, "PWD"=>$dbpass);

$con = sqlsrv_connect($dbhost, $connectionInfo); if(!$con) {
    die(print_r(sqlsrv_errors(), true));
}
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
    if($_SESSION['Role'] != 'admin')
    {
        ?>
        <p>You do not have permission to view this page.  Redirecting in 5 seconds</p>
        <p>Click <a href="/">here</a> if you don't want to wait</p>
        <meta http-equiv='refresh' content='5;/' />
        <?php
    }
    
    elseif(!empty($_POST['session']) && !empty($_POST['year']))
    {
        //$CourseID = $_POST['courseID'];
        
        /* Get POST Variables */
        $session = $_POST['session'];
        $year = $_POST['year'];
        $section = $_POST['section'];
        $teacherlastname = $_POST['teacherlastname'];
        $classname = $_POST['classname']; //need to convert to classnameID
        $CRN = $_POST['CRN'];
        $location = $_POST['location'];
        /* End POST Variables */
        
        /* Get ID tags for SessionsID (Session->SessionID, Year->YearID) */
        $query = "SELECT * FROM Session WHERE Session = '". $session."'";
        $params = array();
        $options = array( "Scrollable" => SQLSRV_CURSOR_FORWARD );
        $stmt = sqlsrv_query($con, $query, $params, $options);
        if( $stmt === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        $result = sqlsrv_fetch( $stmt );
        $sessionid = sqlsrv_get_field( $stmt, 1);

        $queryyear = "SELECT * FROM Year WHERE Year = '". $year."'";
        $stmtyear = sqlsrv_query($con, $queryyear, $params, $options);
        if ($stmtyear === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        $result = sqlsrv_fetch( $stmtyear );
        $yearid = sqlsrv_get_field( $stmtyear, 1);
        
        
        $sessionsquery = "SELECT * FROM Sessions WHERE Session_ID = '". $sessionid."' AND Year_ID = '". $yearid."'";
        $stmtsessions = sqlsrv_query($con, $sessionsquery, $params, $options);
        if ($stmtsessions === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        $result = sqlsrv_fetch( $stmtsessions );
        $sessionsid = sqlsrv_get_field( $stmtsessions, 0);
        echo "$sessionsid";
        
        $classnamequery = "SELECT * FROM "
        
        
    }
    else
    {
        ?>
        <body>
            <div id="header"></div>           
            <div id="wrapper">
                <div id="sidebar"></div>
                <div id="page-content-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Collapse/Expand</a>
                                <h1><?=$_SESSION['FirstName']?> <?=$_SESSION['LastName']?></h1>
                                <p>Documentation:</p>
                                <p>Create Course window.  Form submission for: session, year, section, instructor, class, CRN, location.  All these create Teachers&ClassesID. Submits to the DB.  </p>
                                <p>Form objects:  </p>
                                <p>Choose Session (Fall I, Fall II, Summer I, Summer II, Fall I, Fall II)</p>
                                <p>Choose Year (CurrentYear + 5/4/3/2/1, CurrentYear)</p>
                                <p>Choose Session (1,2)</p>
                                <p>Choose Instructor [Dropdown/LiveSearch]</p>
                                <p>Choose Class Name [Dropdown]</p>
                                <p>CRN [Text] [Optional]</p>
                                <p>Location [Text] [Optional</p>
                                <p>Generate Teachers&ClassesID unique from table</p>
                                <br>
                                <p>Database Connection Steps:</p>
                                <p> 1.)Generate SessionsID from Session and Year. </p>
                                <p> 2.)Generate new Teachers&ClassesID via DB query</p>
                                <p> 3.)Write new query</p>
                                
                                <form method="post" action="" name="getSession" id="getSession">
                                    <fieldset>
                                        <label for="session">Session:</label>
                                        <select id="session" name="session">
                                            <option value="Spring I">Spring I</option>
                                            <option value="Spring II">Spring II</option>
                                            <option value="Summer I">Summer I</option>
                                            <option value="Summer II">Summer II</option>
                                            <option value="Fall I">Fall I</option>
                                            <option value="Fall II">Fall II</option>
                                        </select><br>
                                        <label for="year">Year:</label>
                                        <select id="year" name="year">
                                            <option value="2016">2016</option>
                                            <option value="2017">2017</option>
                                            <option value="2018">2018</option>
                                            <option value="2019">2019</option>
                                            <option value="2020">2020</option>
                                        </select><br>
                                        <label for="section">Section</label>
                                        <select id="section" name="section">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select><br>
                                        <label for="teacherlastname">Teacher's Last Name:</label>
                                        <input type="text" name="teacherlastname" id="teacherlastname"><br>
                                        <label for="classname">Classname:</label>
                                        <input type="text" name="classname" id="classname"><br>
                                        <label for="CRN">CRN:</label>
                                        <input type="text" name="CRN" id="CRN"><br>
                                        <label for="location">Location:</label>
                                        <input type="text" name="location" id="location"><br>
                                        
                                        <button class="button" type="submit">Submit</button>
                                    </fieldset>
                                </form>
                                
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="/js/bootstrap.min.js"></script>
            <script>
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });
            </script>
        </body> 
        <?php        
    }
}

else
{
    ?>
    <p>Oops! You are not logged in.  Redirecting to log-in in 5 seconds</p>
    <p>Click <a href="/">here</a> if you don't want to wait</p>
    <meta http-equiv='refresh' content='5;/' />
    <?php
}
?>

</html>
