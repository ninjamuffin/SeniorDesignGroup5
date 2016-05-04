<!-- Page for the admin user to oversee current courses, and navigate to CreateCourse -->
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
    <link href="/css/SidebarPractice.css" rel="stylesheet">
    <link href="/flatUI/css/theme.css" rel="stylesheet" media="screen">


    <!-- Including Header -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="/js/SidebarPractice.js"></script>
    <script type="text/javascript" src="/js/CreateNewCourse.js"></script>
    <script>
        
        $(function(){
            $("#sidebar").load("/sidebar.php");
        });
    </script>
</head>

<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
    if($_SESSION['Role'] != 'Admin')
    {
        ?>
        <p>You do not have permission to view this page.  Redirecting in 5 seconds</p>
        <p>Click <a href="/">here</a> if you don't want to wait</p>
        <meta http-equiv='refresh' content='5;/' />
        <?php
    }
    else
    {
        $params = array($_SESSION['Username']);
        $options = array( "Scrollable" => 'static' );
        $institutionSQL = "SELECT I.InstitutionID FROM Institutions as I, Administrators as A
                           WHERE A.SiteUsername = ? AND
                                 I.InstitutionID = A.InstitutionID";
        $institution = sqlsrv_query($con, $institutionSQL, $params, $options);
        if ($institution === false)
            die(print_r(sqlsrv_errors(), true));
        if (sqlsrv_fetch($institution) === true)
            $institutionID = sqlsrv_get_field($institution, 0);
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
                            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                <h1>Courses</h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-10">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Add New Course</div>
                                    <div class="panel-body">
                                         <form method="POST" id="filterActivityQueue" action="">
                                            <div class="form-group row">
                                                <div class="col-lg-3">
                                                    <select class="form-control" name="institution">
                                                        <option selected="selected" value="0">--Institution--</option>
                                                        <option value="1">Gonzaga University</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <select class="form-control" name="session">
                                                        <option selected="selected" value="0">--Session--</option>
<?php   
        $params = array();
        $options = array( "Scrollable" => 'static' );
        $sessionsSQL = "SELECT TOP 6 SI.SessionInstanceID, SI.Year, ST.SessionName
                        FROM SessionInstance SI, SessionType ST
                        WHERE ST.SessionTypeID = SI.SessionTypeID
                        ORDER BY SI.Year DESC";
        $sessions = sqlsrv_query($con, $sessionsSQL, $params, $options);
        if ($sessions === false)
            die(print_r(sqlsrv_errors(), true));
        $num_sessions = sqlsrv_num_rows($sessions);
        $ids = [];
        $years = [];
        $session_names = [];
        while (sqlsrv_fetch($sessions) === true)
        {
            $ids[] = sqlsrv_get_field($sessions, 0);
            $years[] = sqlsrv_get_field($sessions, 1);
            $session_names[] = sqlsrv_get_field($sessions, 2);
        }
        for ($i = 0; $i < $num_sessions; $i++)
            echo "<option value=\"$ids[$i]\">$session_names[$i] $years[$i]</option>";
?>                                      
                                                    
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <select class="form-control" name="coursename" >
                                                        <option selected="selected" value="0">--Course Number--</option>
<?php                                                      
        $params = array();
        $options = array( "Scrollable" => 'static' );
        $coursetypesSQL = "SELECT CourseTypesID, CourseName FROM CourseTypes ORDER BY CourseTypesID";
        $coursetypes = sqlsrv_query($con, $coursetypesSQL, $params, $options);
        if ($coursetypes === false)
            die(print_r(sqlsrv_errors(), true));
        $num_course_types = sqlsrv_num_rows($coursetypes);
        $ids = [];
        $levels = [];
        while (sqlsrv_fetch($coursetypes) === true)
        {
            $ids[] = sqlsrv_get_field($coursetypes, 0);
            $levels[] = sqlsrv_get_field($coursetypes, 1);
        }
        for ($i = 0; $i < $num_course_types; $i++)
            echo "<option value=\"$ids[$i]\">$levels[$i]</option>";
?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <select class="form-control" name="section" id="section">
                                                        <option selected="selected" value="0">--Section--</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                    </select>
                                                </div>
                                                
                                                
                                                
                                            </div>
                                             <div class="form-group row" style="padding-right: 15px;">
                                                 <div class="col-lg-9">
                                                     <select class="form-control" name="teacherid" >
                                                        <option selected="selected" value="0">
<?php
        $params = array($institutionID);
        $options = array( "Scrollable" => 'static' );
        $teachersSQL = "SELECT TI.TeachingInstanceID, T.FirstName, T.LastName 
                        FROM TeachingInstance as TI, Teachers as T
                        WHERE TI.InstitutionID = ? AND
                              T.TeacherID = TI.TeacherID
                        ORDER BY T.LastName, T.FirstName";
        $teachers = sqlsrv_query($con, $teachersSQL, $params, $options);
        if ($teachers === false)
            die(print_r(sqlsrv_errors(), true));
        $num_teachers = sqlsrv_num_rows($teachers);
        $ids = [];
        $firstnames = [];
        $lastnames = [];
        while (sqlsrv_fetch($teachers) === true)
        {
            $ids[] = sqlsrv_get_field($teachers, 0);
            $firstnames[] = sqlsrv_get_field($teachers, 1);
            $lastnames[] = sqlsrv_get_field($teachers, 2);
        }
        for ($i = 0; $i < $num_teachers; $i++)
            echo "<option value=\"$ids[$i]\">$firstnames[$i] $lastnames[$i]</option>";
?>
                                                         
                                                        </option>
                                                     </select>
                                                 </div>
                                                    <button type="button" name="CreateCourse" class="btn btn-primary pull-right">Create Course</button>
                                             </div>
                                             
                                        </form>
                                    </div>
                                </div>       
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-10">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Active Courses</div>
                                    <div class="panel-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <td>Institution</td>
                                                    <td>Session Name</td>
                                                    <td>Course Name</td> <!-- Link to page -->
                                                    <td>Section</td>
                                                    <td>Teacher Name</td> <!-- Link to page -->
                                                </tr>
                                            </thead>
                                            <tbody>
<?php
        $params = array();
        $options = array( "Scrollable" => 'static' );
        $coursesSQL = "SELECT I.InstitutionName, ST.SessionName, SI.Year, CT.CourseName, C.Section, T.FirstName, T.LastName
                       FROM Institutions I, SessionType ST, SessionInstance SI, CourseTypes CT, Courses C, TeachingInstance TI, Teachers T
                       WHERE C.Status = 'Active' AND
                             CT.CourseTypesID = C.CourseTypesID AND
                             TI.TeachingInstanceID = C.TeachingInstanceID AND
                             T.TeacherID = TI.TeacherID AND
                             I.InstitutionID = TI.InstitutionID AND
                             SI.SessionInstanceID = C.SessionInstanceID AND
                             ST.SessionTypeID = SI.SessionTypeID
                             ORDER BY CourseID DESC";
        $courses = sqlsrv_query($con, $coursesSQL, $params, $options);
        if ($courses === false)
            die(print_r(sqlsrv_errors(), true));
        $num_courses = sqlsrv_num_rows($courses);
        $institutions = [];
        $session_names = [];
        $years = [];
        $course_names = [];
        $sections = [];
        $teacher_firstnames = [];
        $teacher_lastnames = [];
        while(sqlsrv_fetch($courses) === true)
        {
            $institutions[] = sqlsrv_get_field($courses, 0);
            $session_names[] = sqlsrv_get_field($courses, 1);
            $years[] = sqlsrv_get_field($courses, 2);
            $course_names[] = sqlsrv_get_field($courses, 3);
            $sections[] = sqlsrv_get_field($courses, 4);
            $teacher_firstnames[] = sqlsrv_get_field($courses, 5);
            $teacher_lastnames[] = sqlsrv_get_field($courses, 6);
        }
        for ($i = 0; $i < $num_courses; $i++)
        {
            echo "<tr><td>$institutions[$i]</td>
                      <td>$session_names[$i] $years[$i]</td>
                      <td>$course_names[$i]</td>
                      <td>$sections[$i]</td>
                      <td>$teacher_firstnames[$i] $teacher_lastnames[$i]</td></tr>";
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
