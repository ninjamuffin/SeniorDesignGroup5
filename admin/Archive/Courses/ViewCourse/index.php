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
        $courseID = isset($_POST['courseID']) ? $_POST['courseID'] : 0;
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
            $courseinfoSQL = "
            SELECT CT.CourseName, C.Section, T.FirstName, T.LastName, ST.SessionName, SI.Year, I.InstitutionName
            FROM Courses as C, CourseTypes as CT, Teachers as T, TeachingInstance TI, SessionInstance as SI, SessionType as ST, Institutions as I
            WHERE C.CourseID = ? AND
                  CT.CourseTypesID = C.CourseTypesID AND
                  TI.TeachingInstanceID = C.TeachingInstanceID AND
                  T.TeacherID = TI.TeacherID AND
                  SI.SessionInstanceID = C.SessionInstanceID AND
                  ST.SessionTypeID = SI.SessionTypeID AND
                  I.InstitutionID = C.InstitutionID";
            $courseinfo = sqlsrv_query($con, $courseinfoSQL, $params, $options);
            if ($courseinfo === false)
                die(print_r(sqlsrv_errors(), true));
            if (sqlsrv_fetch($courseinfo) === true)
            {
                $ClassName = sqlsrv_get_field($courseinfo, 0);
                $Section = sqlsrv_get_field($courseinfo, 1);
                $FirstName = sqlsrv_get_field($courseinfo, 2);
                $LastName = sqlsrv_get_field($courseinfo, 3);
                $Session = sqlsrv_get_field($courseinfo, 4);
                $Year = sqlsrv_get_field($courseinfo, 5);
                $Institution = sqlsrv_get_field($courseinfo, 6);
                
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
            $worksheetsSQL = "SELECT W.WorksheetID, W.WorksheetNumber, T.Topic 
                      FROM Worksheets W, Topics T
                      WHERE W.CourseID = ? AND
                            T.TopicID = W.TopicID
                      ORDER BY W.WorksheetNumber";
            $worksheets = sqlsrv_query($con, $worksheetsSQL, $params, $options);
            if (!$worksheets)
                die( print_r( sqlsrv_errors(), true));
            
            $rowsPerPage = 10;
            $rowsReturned = sqlsrv_num_rows($worksheets);
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
            $page = Pagination::getPage($worksheets, $pageNum, $rowsPerPage);
            foreach($page as $row)
            {
                $worksheetID = $row[0];
                echo "<tr>  
                        <td>$row[1]</td>
                        <td><form method=\"POST\" action=\"ViewWorksheet\">
                                <input hidden type=\"text\" name=\"worksheetID\" value=\"$worksheetID\">
                                <button class=\"btn btn-primary\">Worksheet Page</button>
                            </form>
                        </td>
                        <td><form method=\"POST\" action=\"ViewWorksheet/AnnotationEditor/\">
                                <input hidden type=\"text\" name=\"worksheetID\" value=\"$worksheetID\">
                                <button class=\"btn btn-primary\">Annotation Editor</button>
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
