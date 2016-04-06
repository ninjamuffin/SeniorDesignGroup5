<!-- Courses Home (index.php) for Teacher account -->

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
        
        $institutionID = isset($_POST['institutionid']) ? $_POST['institutionid'] : 0;
        
        /*$username = $_SESSION['Username'];
        $params = array($username);
        $teacherIDQuery = "SELECT TeacherID FROM Teachers WHERE [SiteUsername] = ?";
        
        $options = array( "Scrollable" => 'static' );
        $stmt = sqlsrv_query($con, $teacherIDQuery, $params, $options);
        if( $stmt === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $teacherID = 0;
        if ( sqlsrv_fetch( $stmt ) === true)
            $teacherID = sqlsrv_get_field( $stmt, 0);
        else
            echo "SQL ERROR";*/
        
        if ($institutionID == 0)
        {
            $params = array($_SESSION['Username']);
            $options = array( "Scrollable" => 'static' );
            $CoursesQuery = "
            SELECT C.CourseID, CT.CourseName, C.Section, ST.SessionName, SI.Year
            FROM Courses as C, [CourseTypes] as CT, [SessionType] as ST, SessionInstance as SI, TeachingInstance as TI
            WHERE TI.SiteUsername = ? AND
                  C.TeachingInstanceID = TI.TeachingInstanceID AND
                  C.Status = 'Active' AND
                  CT.CourseTypesID = C.CourseTypesID AND
                  SI.SessionInstanceID = C.SessionInstanceID AND
                  ST.SessionTypeID = SI.SessionTypeID";
        }
        else
        {
            $params = array($_SESSION['Username'], $institutionID);
            $options = array( "Scrollable" => 'static' );
            $CoursesQuery = "
            SELECT C.CourseID, CT.CourseName, C.Section, ST.SessionName, SI.Year
            FROM Courses as C, [CourseTypes] as CT, [SessionType] as ST, SessionInstance as SI, TeachingInstance TI
            WHERE TI.SiteUsername= ? AND
                  C.TeachingInstanceID = TI.TeachingInstanceID AND
                  C.Status = 'Active' AND
                  C.InstitutionID = ? AND
                  CT.CourseTypesID = C.CourseTypesID AND
                  SI.SessionInstanceID = C.SessionInstanceID AND
                  ST.SessionTypeID = SI.SessionTypeID";
        }
        
        $stmt = sqlsrv_query($con, $CoursesQuery, $params, $options);
        if ( $stmt === false)
            die( print_r( sqlsrv_errors(), true));
        $length = sqlsrv_num_rows($stmt);

        $courseID = [];
        $ClassNames = [];
        $Sections = [];
        $SessionNames = [];
        $SessionYears = [];
        
        while (sqlsrv_fetch( $stmt ) === true) 
        {
            $courseID[] = sqlsrv_get_field( $stmt, 0);
            $ClassNames[] = sqlsrv_get_field( $stmt, 1);
            $Sections[] = sqlsrv_get_field( $stmt, 2);
            $SessionNames[] = sqlsrv_get_field( $stmt, 3);
            $SessionYears[] = sqlsrv_get_field( $stmt, 4);
        }
        
        $params = array($_SESSION['Username']);
        $institutionsQuery = "SELECT DISTINCT I.InstitutionName, I.InstitutionID FROM Institutions as I, TeachingInstance as TI WHERE TI.SiteUsername = ? AND I.InstitutionID = TI.InstitutionID";
        $stmt = sqlsrv_query( $con, $institutionsQuery, $params, $options);
        if ($stmt === false)
            die (print_r(sqlsrv(errors(), true)));
        $num_institutions = sqlsrv_num_rows($stmt);
        $institutions = [];
        $institutionsIDs = [];
        while (sqlsrv_fetch($stmt) === true)
        {
            $institutions[] = sqlsrv_get_field( $stmt, 0);
            $institutionIDs[] = sqlsrv_get_field( $stmt, 1);
        }
            
    ?>        

    <body>
        <div id="wrapper">
            <div id = "sidebar"></div>
            <div id="page-content-wrapper">
                <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                    <span class="hamb-top"></span>
                    <span class="hamb-middle"></span>
                    <span class="hamb-bottom"></span>
                </button>
                
                
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-10 col-xs-12">
                            <h2>My Courses</h2>
                        </div>
                    </div>
                    <?php
        if ($num_institutions > 1)
        {
            ?>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    Filter Courses
                                </div>
                                <div class="panel-body">
                                    <form method="POST" action="" id="FilterCourses">
                                        <div class="form-group row">
                                            <div class="col-xs-8">
                                                <select class="form-control" name="institutionid">
                                                    <option selected="selected">--Select Institution--</option>
            <?php
        for($i = 0; $i < $num_institutions; $i++)
        {
                ?>
                                                    <option value="<?=$institutionIDs[$i]?>"><?=$institutions[$i]?></option>
                                                    <?php
        }?>
                                                </select>
                                            
                                            </div>
                                            
                                        </div>
                                        <button class="btn btn-primary">Filter My Institutions</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
        }?>
                    
                    <div class="row">
                        <div class="col-md-8 col-sm-6">
                            <div class="panel panel-primary">
                                
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Session</th>
                                                <th>Level</th>
                                                <th>Section</th>
                                                <th>Go To</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        <?php
        for ($i = 0; $i < $length; $i++)
        {
            echo "<tr>";
            echo "<td>$SessionNames[$i] $SessionYears[$i]</td>";
            echo "<td>$ClassNames[$i]</td>";
            echo "<td>$Sections[$i]</td>";
            echo "<td>
                    <form method=\"POST\" action=\"ViewCourse/\" name=\"course{$courseID[$i]}\">
                        <input hidden type=\"text\" value=\"$courseID[$i]\" name=\"courseID\">
                        <input hidden type=\"text\" value=\"$SessionNames[$i]\" name=\"sessionname\">
                        <input hidden type=\"text\" value=\"$SessionYears[$i]\" name=\"sessionyear\">
                        <input hidden type=\"text\" value=\"$ClassNames[$i]\" name=\"classnames\">
                        <input hidden type=\"text\" value=\"$Sections[$i]\" name=\"sections\">
                    <button class=\"btn btn-primary\">Course Page</button></form>";
            
            echo "</td></tr>";

        }?>
                                            
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
