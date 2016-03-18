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
        $courseID = isset($_GET['courseID']) ? $_GET['courseID'] : 0;
        if ($courseID == 0)
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
                            <div class="col-lg-3 col-md-4 col-sm-6">     
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Course Info</div>
                                    <div class="panel-body">
                                    <?php
            $params = array($courseID);
            $options = array( "Scrollable" => 'static');
            $courseInfoQuery = "
            SELECT TC.CoursesID, CN.ClassName, TC.Section, T.FirstName, T.LastName, SN.SessionName, I.InstitutionName
            FROM Courses as TC, [Class Names] as CN, Teachers as T, Sessions as Ss, SessionNames as SN, Institutions as I
            WHERE TC.CoursesID = ? AND
                  CN.ClassNamesID = TC.ClassNamesID AND
                  T.TeacherID = TC.InstructorID AND
                  Ss.SessionsID = TC.SessionID AND
                  SN.SessionsID = Ss.SessionsID";
            $stmt = sqlsrv_query($con, $courseInfoQuery, $params, $options);
            if ($stmt === false)
                die(print_r(sqlsrv_errors(), true));
            if (sqlsrv_fetch($stmt) === true)
            {
                $ClassName = sqlsrv_get_field($stmt, 1);
                $Section = sqlsrv_get_field($stmt, 2);
                $FirstName = sqlsrv_get_field($stmt, 3);
                $LastName = sqlsrv_get_field($stmt, 4);
                $Session = sqlsrv_get_field($stmt, 5);
                $Institution = sqlsrv_get_field($stmt, 6);
                
            }
            echo "<p>Class Name: $ClassName</p><p>Section: $Section</p><p>Teacher: $FirstName $LastName</p><p>Session: $Session</p><p>Hosting Institution: $Institution</p>";
                                        
                                        
                                        ?>
                                    
                                    </div>
                                </div> 
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="panel panel-primary" style="max-height:350px; ">
                                    <div class="panel-heading">Worksheet display</div>
                                    <div class="panel-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Go To</th>
                                                    <th>Annotate this worksheet</th>
                                                </tr>
                                            </thead>
                                            <tbody>
        <?php
            $params = array($courseID);
            $options = array( "Scrollable" => 'static' );
            $query = "SELECT [Worksheet#], [Teachers&ClassesID] FROM Expressions WHERE [Teachers&ClassesID] = ? GROUP BY [Worksheet#],[Teachers&ClassesID]";
            $stmt = sqlsrv_query($con, $query, $params, $options);
            if (!$stmt)
                die( print_r( sqlsrv_errors(), true));
            
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
                $numOfPages = ceil($rowsReturned/$rowsPerPage);
            }
            
            $pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1;
            $page = Pagination::getPage($stmt, $pageNum, $rowsPerPage);
            foreach($page as $row)
            {
                $worksheetPageLink = "ViewWorksheet/?courseID=$row[1]&worksheetNum=$row[0]";
                $annotationPageLink = "ViewWorksheet/AnnotationEditor/?courseID=$row[1]&worksheetNum=$row[0]";
                echo "<tr><td>$row[0]</td><td><a href='$worksheetPageLink'>Worksheet Page</a></td><td><a href='$annotationPageLink'>Annotation Editor</a></td></tr>";
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
