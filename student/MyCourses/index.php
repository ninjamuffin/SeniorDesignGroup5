<!-- My Courses Page (index.html) for basic Student account -->
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
    if($_SESSION['Role'] != 'Student')
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
                    <div class="col-lg-8 col-xs-12 col-md-8">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3>Courses</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Course Number</th>
                                            <th>Course Name</th>
                                            <th>Session Name</th>
                                            <th>Teacher</th>
                                            <th>Visit Course Page</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
        $params = array($_SESSION['Username']);
        $options = array( "Scrollable" => 'static' );
        $coursesSQL = "SELECT CT.CourseName, CT.CourseTypeName, ST.SessionName, SI.Year, T.FirstName, T.LastName, C.CourseID
                       FROM CourseTypes CT, SessionType ST, SessionInstance SI, Students S, Courses C, Enrollment ER, Teachers T, TeachingInstance TI
                       WHERE S.SiteUsername = ? AND
                             ER.StudentID = S.StudentID AND
                             C.CourseID = ER.CourseID AND
                             C.TeachingInstanceID = TI.TeachingInstanceID AND
                             TI.TeacherID = T.TeacherID AND
                             SI.SessionInstanceID = C.SessionInstanceID AND
                             ST.SessionTypeID = SI.SessionTypeID AND
                             CT.CourseTypesID = C.CourseTypesID";
        $courses = sqlsrv_query($con, $coursesSQL, $params, $options);
        if ($courses === false)
            die(print_r(sqlsrv_errors(), true));
        $num_courses = sqlsrv_num_rows($courses);
        $course_numbers = [];
        $course_names = [];
        $session_names = [];
        $years = [];
        $teacher_firstnames = [];
        $teacher_lastnames = [];
        $course_ids = [];
        while(sqlsrv_fetch($courses) === true)
        {
            $course_numbers[] = sqlsrv_get_field($courses, 0);
            $course_names[] = sqlsrv_get_field($courses, 1);
            $session_names[] = sqlsrv_get_field($courses, 2);
            $years[] = sqlsrv_get_field($courses, 3);
            $teacher_firstnames[] = sqlsrv_get_field($courses, 4);
            $teacher_lastnames[] = sqlsrv_get_field($courses, 5);
            $course_ids[] = sqlsrv_get_field($courses, 6);
        }
        for ($i = 0; $i < $num_courses; $i++)
        {
            echo "<tr><td>$course_numbers[$i]</td>
                      <td>$course_names[$i]</td>
                      <td>$session_names[$i] $years[$i]</td>
                      <td>$teacher_firstnames[$i] $teacher_lastnames[$i]</td>
                      <td><form method=\"POST\" action=\"ViewCourse/\" name=\"courseid{$i}\">
                            <input hidden type=\"text\" name=\"courseID\" value=\"$course_ids[$i]\">
                            <button class=\"btn btn-primary\">View Course</button>
                          </form>
                      </td>
                    </tr>";
        }
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