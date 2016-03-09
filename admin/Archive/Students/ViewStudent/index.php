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
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
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
        $studentID = isset($_GET['studentID']) ? $_GET['studentID'] : 0;
        if ($studentID == 0)
            echo "<meta http-equiv='refresh' content=0;../";
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
                            <div class="col-lg-10">
                                <h4>Student Name</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-10">
                                
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Student Information</div>
                                    <div class="panel-body">
                                        <p>Institution:</p>
                                        <p>Joined Smalltalk:</p>
                                        <p>Number of Courses:</p>
                                        <p>Language:</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-10 col-md-10">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Student Courses</div>
                                    <div class="panel-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <td>Course Number</td>
                                                    <td>Instructor Last Name</td>
                                                    <td>Session Name</td>
                                                    <td>Course Page</td>
                                                </tr>
                                            </thead>
                                            <tbody>

<?php
/* Set up and declare query entity */
$params = array($studentID);
$options = array( "Scrollable" => 'static' );
$query = 
"SELECT  CN.[ClassName], TC.[Section], T.[LastName], SN.[SessionName], TC.[CoursesID], T.[TeacherID]
FROM [TeachersCourses] as TC, Teachers as T, [Class Names] as CN, [Sessions] as Ss, SessionNames as SN
WHERE TC.[ClassNamesID] = CN.[ClassNamesID] AND 
      TC.[InstructorID] = T.[TeacherID] AND 
	  TC.[SessionID] = Ss.[SessionsID] AND
	  SN.[SessionsID] = Ss.[SessionsID] AND
      TC.[CoursesID] in (SELECT DISTINCT OtherExpressions.[Teachers&ClassesID] FROM Expressions as OtherExpressions WHERE OtherExpressions.[Student_ID] = ?)
ORDER BY Ss.[SessionsID] desc";
$stmt = sqlsrv_query($con, $query, $params, $options);
if ( !$stmt )
    die( print_r( sqlsrv_errors(), true));

/* Extract Pagination Paramaters */
$rowsPerPage = 10;
$rowsReturned = sqlsrv_num_rows($stmt);
if($rowsReturned === false)
    die(print_r( sqlsrv_errors(), true));
elseif($rowsReturned == 0)
{
    echo "No rows returned.";
    exit();
}
else
{
    /* Calculate number of pages. */
    $numOfPages = ceil($rowsReturned/$rowsPerPage);
}

/* Echo results to the page */
$pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1;
$page = Pagination::getPage($stmt, $pageNum, $rowsPerPage);
foreach($page as $row)
{
    $coursePageLink = "/Admin/Archive/Courses/ViewCourse/?courseID=$row[4]";
    $teacherPageLink = "/Admin/Archive/Teachers/ViewTeacher/?tid=$row[5]";
    echo "<tr><td>$row[0]</td><td><a href='$teacherPageLink'>$row[2]</a></td><td>$row[3]</td><td><a href='$coursePageLink'>Course Page</a></td></tr>";
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
