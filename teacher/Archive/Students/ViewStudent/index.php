<?php 
include "../../../../base.php";
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
    <link href="/FlatUI/css/theme.css" rel="stylesheet" media="screen">

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
        $studentID = isset($_POST['studentID']) ? $_POST['studentID'] : 0;
        if ($studentID == 0)
            echo "<meta http-equiv='refresh' content=0;../";
        
        $studentfirstname = isset($_POST['studentfirstname']) ? $_POST['studentfirstname'] : '';
        $studentlastname = isset($_POST['studentlastname']) ? $_POST['studentlastname'] : '';
        
        $params = array($studentID);
        $options = array("Scrollable" => 'static' );
        $studentinfoSQL = "SELECT CONVERT(VARCHAR(11), SU.date_added,106), ST.SessionName, SI.Year
                           FROM Students S, SiteUsers SU, SessionType ST, SessionInstance SI, Enrollment ER, Courses C
                           WHERE S.StudentID = ? AND
                                 SU.username = S.SiteUsername AND
                                 ER.StudentID = S.StudentID AND
                                 C.CourseID = ER.CourseID AND
                                 SI.SessionInstanceID = C.SessionInstanceID AND
                                 ST.SessionTypeID = SI.SessionTypeID";
        $studentinfo = sqlsrv_query($con, $studentinfoSQL, $params, $options);
        if ($studentinfo === false)
            die(print_r(sqlsrv_errors(), true));
        if (sqlsrv_fetch($studentinfo) === true)
        {
            $last_session = sqlsrv_get_field($studentinfo, 0);
            $date_added = sqlsrv_get_field($studentinfo, 1);
            $year_added = sqlsrv_get_field($studentinfo, 2);
            
        }
        
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
                            <div class="col-md-12">
                                <h4><?php echo "$studentfirstname $studentlastname";?></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Student Information</div>
                                    <div class="panel-body">
                                        <p>Last Active Session: <?=$date_added?> <?=$year_added?></p>
                                        <p>Joined SmallTalk: <?=$last_session?></p>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">        
                                <div class="panel panel-primary" style="min-height: 300px;max-height: 300px; ">
                                    <div class="panel-heading">
                                        Statistics/Performance Review
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-lg-10 col-md-10">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Student Expressions</div>
                                    <div class="panel-body">    
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Expression</th>
                                                    <th>Context/Vocab</th>
                                                    <th>Session</th>
                                                    <th>Course</th>
                                                    <th>Worksheet Number</th>
                                                    <th>Worksheet</th>
                                                </tr>
                                            </thead>
                                            <tbody>
    <?php
            $params = array($studentID);
            $studentexpressionsSQL = "SELECT E.Expression, E.[Context/Vocabulary], ST.SessionName, SI.Year, CT.CourseName, W.WorksheetNumber, W.WorksheetID
            FROM Expressions E, SessionType ST, SessionInstance SI, CourseTypes CT, Courses C,  Worksheets W, Enrollment ER
            WHERE ER.StudentID = ? AND
                  C.CourseID = ER.CourseID AND
                  W.CourseID = C.CourseID AND
                  E.WorksheetID = W.WorksheetID AND
                  E.EnrollmentID = ER.EnrollmentID AND
                  CT.CourseTypesID = C.CourseTypesID AND
                  SI.SessionInstanceID = C.SessionInstanceID AND
                  ST.SessionTypeID = SI.SessionTypeID";
            $studentexpressions = sqlsrv_query($con, $studentexpressionsSQL, $params, $options);
            if ($studentexpressions === false)
                die(print_r(sqlsrv_errors(), true));
            $numexpressions = sqlsrv_num_rows($studentexpressions);
            $expressions = [];
            $contexts = [];
            $sessionnames = [];
            $years = [];
            $coursenames = [];
            $worksheetnums = [];
            $worksheetids = [];
            while (sqlsrv_fetch($studentexpressions) === true)
            {
                $expressions[] = sqlsrv_get_field($studentexpressions, 0);
                $contexts[] = sqlsrv_get_field($studentexpressions, 1);
                $sessionnames[] = sqlsrv_get_field($studentexpressions, 2);
                $years[] = sqlsrv_get_field($studentexpressions, 3);
                $coursenames[] = sqlsrv_get_field($studentexpressions, 4);
                $worksheetnums[] = sqlsrv_get_field($studentexpressions, 5);
                $worksheetids[] = sqlsrv_get_field($studentexpressions, 6);
            }
        for($i = 0; $i < $numexpressions; $i++)
            echo "<tr><td>$expressions[$i]</td>
                      <td>$contexts[$i]</td>
                      <td>$sessionnames[$i] $years[$i]</td>
                      <td>$coursenames[$i]</td>
                      <td>$worksheetnums[$i]</td>
                      <td><form method=\"POST\" action=\"/teacher/Archive/Courses/ViewCourse/ViewWorksheet/\" name=\"worksheet{$worksheetids[$i]}\">
                      <input hidden type=\"text\" value=\"$worksheetids[$i]\" name =\"worksheetID\">
                      <button class=\"btn btn-primary\">View Worksheet</button></form></td></tr>";
        ?>
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
