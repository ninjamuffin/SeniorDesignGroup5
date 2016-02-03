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
    
    elseif(!empty($_POST['session']))
    {
        //$CourseID = $_POST['courseID'];
        $session = $_POST['session'];
        
        //$Year = $_POST['year'];
        //$Section = $_POST['section'];
        //$ClassName = $_POST['instructorLastName'];
        //$CRN = $_POST['CRN'];
        //$Location = $_POST['location'];
        $query = "SELECT * FROM Session WHERE Session = 'Spring I'";
        $params = array();
        $options = array( "Scrollable" => "dynamic" );
        $stmt = sqlsrv_query($con, $query, $params, $options);
        $row_count = sqlsrv_num_rows($stmt);
        
        if ($row_count === false)
        {
            echo "Error in retrieving row count";
        }
        else
        {
            
            echo $row_count;
        }
        
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
                                        <select id="session" name="session">
                                            <option value="Spring I">Spring I</option>
                                            <option value="Spring II">Spring II</option>
                                            <option value="Summer I">Summer I</option>
                                            <option value="Summer II">Summer II</option>
                                            <option value="Fall I">Fall I</option>
                                            <option value="Fall II">Fall II</option>
                                        </select>
                                        <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
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
