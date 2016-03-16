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
        $tid = isset($_GET['tid']) ? $_GET['tid'] : 0;
        if ($tid == 0)
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
                            <div class="col-lg-4">
                                
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Teacher Information</div>
                                    <div class="panel-body">
                                        <?php
            $params = array($tid);
            $options = array( "Scrollable" => 'static' );
            $teacherNameQuery = "SELECT T.FirstName, T.LastName
            FROM Teachers as T
            WHERE T.TeacherID = ?";
            $stmt = sqlsrv_query( $con, $teacherNameQuery, $params, $options);
            if ($stmt === false)
                die(print_r(sqlsrv_errors(), true));
            if( sqlsrv_fetch($stmt) === true)
            {
                $firstName = sqlsrv_get_field( $stmt, 0);
                $lastName = sqlsrv_get_field( $stmt, 1);
            }
            
            
            
            
            $firstYearRangeQuery = "
            SELECT min(Y.Year) 
	        FROM Year as Y, Sessions as Ss, TeachersCourses as TC 
	        WHERE	TC.InstructorID = ? AND
			        Ss.SessionsID = TC.SessionID AND
			        Y.ID = Ss.Year_ID";
                  
            $stmt = sqlsrv_query( $con, $firstYearRangeQuery, $params, $options);
            if ($stmt === false)
                die(print_r(sqlsrv_errors(), true));
            
            if( sqlsrv_fetch($stmt) === true)
                $firstYear = sqlsrv_get_field( $stmt, 0);

            $lastYearRangeQuery = "
            SELECT max(Y.Year) 
	        FROM Year as Y, Sessions as Ss, TeachersCourses as TC 
	        WHERE	TC.InstructorID = ? AND
			        Ss.SessionsID = TC.SessionID AND
			        Y.ID = Ss.Year_ID";
                  
            $stmt = sqlsrv_query( $con, $lastYearRangeQuery, $params, $options);
            if ($stmt === false)
                die(print_r(sqlsrv_errors(), true));
            
            if( sqlsrv_fetch($stmt) === true)
                $lastYear = sqlsrv_get_field( $stmt, 0);
            
            echo "<p>Name: $firstName $lastName</p>";
            echo "<p>Active with Smalltalk from: $firstYear - $lastYear</p>";
            
            ?>
                                    </div>
                                </div>
                                
                                
                            </div>
                            <div class="col-lg-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        Active Institutions
                                    </div>
                                    <div class="panel-body">
                                    <?php
            $params = array($tid);
            $options = array( "Scrollable" => 'static');
            $institutionsQuery = "SELECT I.InstitutionName
            FROM Teachers as T,  TeachingInstance as TI, Institutions as I
            WHERE T.TeacherID = ? AND
                  TI.SiteUsername = T.SiteUsername AND
                  I.InstitutionID = TI.InstitutionID";
            $stmt = sqlsrv_query( $con, $institutionsQuery, $params, $options);
            if ($stmt === false)
                die(print_r(sqlsrv_errors(), true));
            $institutions = [];
            while( sqlsrv_fetch($stmt) === true)
                $institutions[] = sqlsrv_get_field( $stmt, 0);
            ?>
                                    
                                        <div class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <?php
                foreach($institutions as $institution)
                    echo "<td>$institution</td>";
                ?>
                                                </tr>
                                            </thead>
                                        </div>
                                        </div>
                                </div>
                                
            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Teacher's Course Listing (sort by most recent)</div>
                                    <div class="panel-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Course Number</th>
                                                    <th>Institution</th>
                                                    <th>Section</th>
                                                    <th>Session Name</th>
                                                    <th>Course Page</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                                /* Set up and declare query entity */
                                                $params = array($tid);
                                                $options = array( "Scrollable" => 'static' );
                                                $query = 
"SELECT  CN.[ClassName], I.InstitutionName, TC.[Section], SN.[SessionName], TC.[CoursesID]
FROM [TeachersCourses] as TC, [Teachers] as T, [Class Names] as CN, [Sessions] as Ss, SessionNames as SN, Institutions as I, TeachingInstance as TI
WHERE TC.[ClassNamesID] = CN.[ClassNamesID] AND 
      TC.[InstructorID] = T.[TeacherID] AND 
      TC.CoursesID in (SELECT [Teachers&ClassesID] from Expressions) AND
      T.[TeacherID] = ? AND
      TI.[SiteUsername] = T.[SiteUsername] AND
      I.InstitutionID = TI.[InstitutionID] AND
	  TC.[SessionID] = Ss.[SessionsID] AND
	  SN.[SessionsID] = Ss.[SessionsID]
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
    echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td><a href='$coursePageLink'>Course Page</a></td></tr>";
}

echo "</tbody></table><br />";
$modulator = 3;
Pagination::pageLinksArchiveViewTeacher($numOfPages, $pageNum, $rowsPerPage, $rowsReturned, $modulator, $tid);
?>
                                            
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
