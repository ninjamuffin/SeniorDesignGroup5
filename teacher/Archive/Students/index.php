<?php 
include "../../../base.php";
?>
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
    <link href="/css/SidebarPractice.css" rel="stylesheet">
    <link href="/flatUI/css/theme.css" rel="stylesheet" media="screen">


    <!-- Including Header -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="/js/SidebarPractice.js"></script>
    <script>
        $(function(){
            $("#header").load("/header.php");
        });
        $(function(){
            $("#sidebar").load("/sidebar.php");
        });
    </script>

</head>

<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
    if($_SESSION['Role'] != 'Teacher')
    {
        ?>
        <p>You do not have permission to view this page.  Redirecting in 5 seconds</p>
        <p>Click <a href="/">here</a> if you don't want to wait</p>
        <meta http-equiv='refresh' content='5;/' />
        <?php
    }
    else
    {
        ?>
        <body>
            <div id="wrapper">
                <div id="sidebar"></div>
                <div id="page-content-wrapper">
                    <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                                    <span class="hamb-top"></span>
                                    <span class="hamb-middle"></span>
                                    <span class="hamb-bottom"></span>
                    </button>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-10">
                                
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Search for a Student</div>
                                    <div class="panel-body">
                                        <form method="POST" id="filterTeachers" action="">
                                            <div class="form-group row">
                                                <div class="col-lg-10">
                                                    <label>Start Typing a Student Name:<input class="form-control" id="LastName" type="text" placeholder="Student Last Name" /></label>    
                                                </div> 
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                
                                <div class="panel panel-primary" style="max-height:600px;">
                                    <div class="panel-heading">Students</div>
                                    
                                    <div class="panel-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Last Active Session</th>
                                                    <th>Go To</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php
        $params = array($_SESSION['Username']);
        $options = array( "Scrollable" => 'static' );
        $mystudentsSQL = "SELECT S.FirstName, S.LastName, S.StudentID, ST.SessionName, SI.Year
                          FROM Students as S, SessionType as ST, SessionInstance as SI, TeachingInstance as TI, Enrollment as ER, Courses as C
                          WHERE TI.SiteUsername = ? AND
                                C.TeachingInstanceID = TI.TeachingInstanceID AND
                                ER.CourseID = C.CourseID AND
                                S.StudentID = ER.StudentID AND
                                SI.SessionInstanceID = C.SessionInstanceID AND
                                ST.SessionTypeID = SI.SessionTypeID";
        $mystudents = sqlsrv_query($con, $mystudentsSQL, $params, $options);
        if ($mystudents === false)
            die(print_r(sqlsrv_errors(), true));
        $numstudents = sqlsrv_num_rows($mystudents);
        $firstnames = [];
        $lastnames = [];
        $ids = [];
        $sessionnames = [];
        $years = [];
        while (sqlsrv_fetch($mystudents) === true)
        {
            $firstnames[] = sqlsrv_get_field($mystudents, 0);
            $lastnames[] = sqlsrv_get_field($mystudents, 1);
            $ids[] = sqlsrv_get_field($mystudents, 2);
            $sessionnames[] = sqlsrv_get_field($mystudents, 3);
            $years[] = sqlsrv_get_field($mystudents, 4);
        }
        for($i = 0; $i < $numstudents; $i++)
        {
            $id = $ids[$i];
            echo "<tr>
                      <td>$firstnames[$i] $lastnames[$i]</td>
                      <td>$sessionnames[$i] $years[$i]</td>
                      <td><form method=\"POST\" action=\"ViewStudent/\" name=\"student{$id}\" id=\"student{$id}\">
                            <input hidden type=\"text\" value=\"$id\" name=\"studentID\">
                            <input hidden type=\"text\" value=\"$firstnames[$i]\" name=\"studentfirstname\">
                            <input hidden type=\"text\" value=\"$lastnames[$i]\" name=\"studentlastname\">
                            <button class=\"btn btn-primary\">Student Page</button></form></td></tr>";
        
        }
        ?>
                                                <!--<tr>
                                                    <td>Good Student</td>
                                                    <td>Fall II 2014</td>
                                                    <td>Advanced Oral Communication</td>
                                                    <td><a href='ViewStudent/?sid=1'>Student Page</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Bad Student</td>
                                                    <td>Fall I 2014</td>
                                                    <td>Basic Oral Communication</td>
                                                    <td><a href='ViewStudent/?sid=1'>Student Page</a></td>
                                                </tr>-->
                                                
                                            </tbody>
                                        </table>


                                            
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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
