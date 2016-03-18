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

    <!-- Background Setup -->

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
                                <div class="panel panel-primary" style="min-height: 500px; max-height: 500px;">
                                    <div class="panel-heading">Courses Archive</div>
                                    <!-- Select Rows Per Page -->
                                    <div class="row">
                                        <div class="col-xs-10">
                                            <div class="dropdown">
                                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                Select rows per page
                                                <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                    <li><a href="?pp=10">10</a></li>
                                                    <li><a href="?pp=25">25</a></li>
                                                    <li><a href="?pp=50">50</a></li>
                                                    <li><a href="?pp=100">100</a></li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="" name="Filter" id="Filter">  
                                        <div class="form-group row">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                <select class="form-control">
                                                    <option selected="selected">--Institution--</option>
                                                    <option>Gonzaga University</option>
                                                    <option>Spokane Falls CC</option>
                                                    <option>Other...</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                <select class="form-control">
                                                    <option selected="selected">--Teacher--</option>
                                                    <option>Hunter</option>
                                                    <option>Momono</option>
                                                    <option>Other...</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                <select class="form-control">
                                                    <option selected="selected">--Level--</option>
                                                    <option>Entry</option>
                                                    <option>Basic</option>
                                                    <option>Intermediate</option>
                                                    <option>Advanced</option>
                                                    <option>Seminar</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                <select class="form-control">
                                                    <option selected="selected">--Year--</option>
                                                    <option>2016</option>
                                                    <option>2015</option>
                                                    <option>2014</option>
                                                    <option>...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                                    </form>
                                    
                                    <div class="panel-body" >                           
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Course</th>
                                                    <th>Instructor</th>
                                                    <th>Session Name</th>
                                                    <th>Go To</th>
                                                </tr>
                                            </thead>
                                            <tbody>

<?php
    /* Set up and declare query entity */
    $params = array();
    $options = array( "Scrollable" => 'static' );
    $query = "  SELECT  CN.[ClassName], TC.[Section], T.[LastName], SN.SessionName, TC.[CoursesID], TC.[InstructorID]
                FROM [Courses] as TC, [Teachers] as T, [Class Names] as CN, [Sessions] as Ss, SessionNames as SN
                WHERE TC.[ClassNamesID] = CN.[ClassNamesID] AND 
                TC.[InstructorID] = T.[TeacherID] AND 
                TC.[SessionID] = Ss.[SessionsID] AND
                TC.CoursesID in (SELECT [Teachers&ClassesID] from Expressions) AND
                SN.[SessionsID] = Ss.[SessionSID]
                ORDER BY Ss.[SessionsID] desc";
    $stmt = sqlsrv_query($con, $query, $params, $options);
    if ( !$stmt )
        die( print_r( sqlsrv_errors(), true));

    /* Extract Pagination Paramaters */

    $rowsPerPage = isset($_GET['pp']) ? $_GET['pp'] : 10; // get rows per page, default = 10


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
        $coursePageLink = "ViewCourse/?courseID=$row[4]";
        $teacherPageLink = "/Admin/Archive/Teachers/ViewTeacher/?tid=$row[5]";
        echo "<tr><td>$row[0]</td><td><a href='$teacherPageLink'>$row[2]</a></td><td>$row[3]</td><td><a href='$coursePageLink'>Course Page</a></td></tr>";
    }

    echo "</tbody></table><br />";
    $modulator = 3;
    Pagination::pageLinks($numOfPages, $pageNum, $rowsPerPage, $rowsReturned, $modulator);
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
