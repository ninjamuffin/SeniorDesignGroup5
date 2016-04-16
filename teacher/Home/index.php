<!-- Home (index.html) for Teacher account -->
<?php include "../../base.php"; ?>
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
    <link rel="stylesheet/less" type="text/css" href="/datepicker.less" />
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
        $username = $_SESSION['Username'];
        $role = $_SESSION['Role'];
        $params = array( $username, $role);
        $options = array( "Scrollable" => 'static' );
        $UserInfoQuery = "
        SELECT R.Designation 
        FROM RoleInstances as RI, Roles as R 
        WHERE  RI.SiteUsername = ? AND 
               R.Role = ? AND 
               R.RoleID = RI.RoleID";
        $stmt = sqlsrv_query($con, $UserInfoQuery, $params, $options);
        if ( $stmt === false)
            die( print_r( sqlsrv_errors(), true));
        $Designation = "";
        $Institution = "";
        if ( sqlsrv_fetch( $stmt ) === true)
        {
            $Designation = sqlsrv_get_field( $stmt, 0);
        }
        ?>
        <body>
<!--
            <div id="header"></div>           
-->
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
                            <div class="col-lg-8 col-md-8">
                                <h3><?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname']; ?></h3>
                                
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-lg-5 col-md-6 col-sm-7">
                                <div class="panel panel-default" style="min-height:600px;">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-10">
                                                <h4>Active Courses</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="min-height: 150px; max-height: 150px;">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Course</th>
                                                    <th>Section</th>
                                                    <th>Session</th>
                                                    <th>Institution</th>
                                                    <th>Go To</th>
                                                </tr>
                                            </thead>
                                                         
                                            <tbody>
                                                <?php
                                                $activecoursesSQL = "SELECT CT.CourseName, C.Section, I.InstitutionName, ST.SessionName, C.CourseID
                                                FROM Courses as C, TeachingInstance as TI, SessionType as ST, SessionInstance as SI, Institutions as I, CourseTypes as CT
                                                WHERE C.TeachingInstanceID = TI.TeachingInstanceID
                                                AND TI.SiteUsername = ?
                                                AND C.SessionInstanceID = SI.SessionInstanceID
                                                AND SI.SessionTypeID = ST.SessionTypeID
                                                AND C.InstitutionID = I.InstitutionID
                                                AND CT.CourseTypesID = C.CourseTypesID
                                                AND C.Status = 'Active'";
                                                
                                                $params = array($_SESSION['Username']);
                                                $options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
                                                
                                                $activecourses = sqlsrv_query($con, $activecoursesSQL, $params, $options);
                                                if($activecourses === false)
                                                    die (print_r(sqlsrv_errors(), true));
                                                $resultlength = sqlsrv_num_rows($activecourses);
                                                if($resultlength == 0)
                                                {
                                                    echo "No Active Courses!";
                                                }
                                                else
                                                {
                                                    $coursenames = [];
                                                    $sections = [];
                                                    $institutions = [];
                                                    $sessions = [];
                                                    $courseids = [];
                                                    while(sqlsrv_fetch($activecourses) === true)
                                                    {
                                                        $coursenames[] = sqlsrv_get_field($activecourses, 0);
                                                        $sections[] = sqlsrv_get_field($activecourses, 1);
                                                        $institutions[] = sqlsrv_get_field($activecourses, 2);
                                                        $sessions[] = sqlsrv_get_field($activecourses, 3);
                                                        $courseids[] = sqlsrv_get_field($activecourses, 4);
                                                    }
                                                    for ($i = 0; $i < $resultlength; $i++)
                                                    {
                                                        echo "<tr><td>$coursenames[$i]</td><td>$sections[$i]</td><td>$sessions[$i]</td><td>$institutions[$i]</td><td><form method=\"post\" action=\"/Teacher/MyCourses/ViewCourse/\" name=\"activecourselink{$i}\" id=\"activecourselink{$i}\"><input hidden type=\"text\" name=\"courseID\" value=\"$courseids[$i]\"><button class=\"btn btn-primary\">Course Page</button></form>
                                                        </td></tr>";
                                                    }
                                                }
                                                
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-5">
                                <div class="panel panel-default" style="min-height:600px;">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-10">
                                                    <h4>My Students</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Course</th>
                                                    <th>Institution</th>
                                                    <th>Go To</th>
                                                </tr>
                                            </thead>
                                        
                                                
                                            <tbody>
                                                <?php
                                                $mystudentsSQL = "SELECT ER.EnrollmentID, S.LastName, S.FirstName, I.InstitutionName, CT.CourseName, C.CourseID
                                                FROM Courses as C, TeachingInstance as TI, Students as S, Institutions as I, Enrollment as ER, CourseTypes as CT
                                                WHERE TI.SiteUsername = ?
                                                AND C.TeachingInstanceID = TI.TeachingInstanceID
                                                AND ER.CourseID = C.CourseID
                                                AND S.StudentID = ER.StudentID
                                                AND I.InstitutionID = S.InstitutionID
                                                AND CT.CourseTypesID = C.CourseTypesID";
                                                
                                                $params = array($_SESSION['Username']);
                                                $options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
                                                
                                                $mystudents = sqlsrv_query($con, $mystudentsSQL, $params, $options);
                                                if($mystudents === false)
                                                    die (print_r(sqlsrv_errors(), true));
                                                $resultlength = sqlsrv_num_rows($mystudents);
                                                if($resultlength == 0)
                                                {
                                                    echo "No Enrolled Students!";
                                                }
                                                else
                                                {
                                                    $enrollmentids = [];
                                                    $studentlastnames = [];
                                                    $studentfirstnames = [];
                                                    $institutions = [];
                                                    $coursenames = [];
                                                    $courseids = [];
                                                    while(sqlsrv_fetch($mystudents) === true)
                                                    {
                                                        $enrollmentids[] = sqlsrv_get_field($mystudents, 0);
                                                        $studentlastnames[] = sqlsrv_get_field($mystudents, 1);
                                                        $studentfirstnames[] = sqlsrv_get_field($mystudents, 2);
                                                        $institutions[] = sqlsrv_get_field($mystudents, 3);
                                                        $coursenames[] = sqlsrv_get_field($mystudents, 4);
                                                        $courseids[] = sqlsrv_get_field($mystudents, 5);
                                                    }
                                                    for ($i = 0; $i < $resultlength; $i++)
                                                    {
                                                        echo "<tr><td>$studentfirstnames[$i] $studentlastnames[$i]</td><td>$coursenames[$i]</td><td>$institutions[$i]</td><td><form method=\"post\" action=\"/Teacher/MyCourses/ViewCourse/Students/ViewStudentProfile/\" name=\"mystudentlink{$i}\" id=\"mystudentlink{$i}\"><input hidden type=\"text\" name=\"enrollmentID\" value=\"$enrollmentids[$i]\"><input hidden type=\"text\" name=\"courseID\" value=\"$courseids[$i]\"><button class=\"btn btn-primary\">Student Page</button></form>
                                                        </td></tr>";
                                                    }
                                                }
                                                
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <!--<div class="row">
                            <div class="col-lg-8 col-md-8">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4>My Site Activity Queue</h4>
                                    </div>
                                    <div class="panel-body" style="min-height: 250px;max-height: 250px;">
                                        <form method="POST" id="filterActivityQueue" action="">
                                            <div class="form-group row">
                                                <div class="col-lg-3 col-md-3 col-sm-4">
                                                    <select class="form-control">
                                                        <option selected="selected">--Institution--</option>
                                                        <option>Gonzaga</option>
                                                        <option>Spokane Falls CC</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-4">
                                                    <select class="form-control" style="display:inline">
                                                        <option selected="selected">--Course--</option>
                                                        <option>Course Info</option>
                                                        <option>Course Info</option>
                                                        <option>Course Info</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-4">
                                                    <select class="form-control">
                                                        <option selected="selected">--Action Type--</option>
                                                        <option>Submitted Worksheet</option>
                                                        <option>Question</option>
                                                        <option>Submitted Other</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Filter Activity Queue</button>
                                            </div>
                                        </form>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Institution</th>
                                                    <th>Course</th>
                                                    <th>Action Type</th>
                                                    <th>User</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1/28/2016</td>
                                                    <td>Gonzaga University</td>
                                                    <td>Seminar: Spring I 2016</td>
                                                    <td><a href="/Teacher/MyCourses/ViewCourse/ViewWorksheet/ViewSubmission/">Worksheet Submission</a></td>
                                                    
                                                    <td><a href="/Teacher/MyStudents/ViewStudentProfile/">Student Name</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>-->
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
