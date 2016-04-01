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
        $institutionID = isset($_GET['in']) ? $_GET['in'] : 0; // Default Institution = 1
        
        $username = $_SESSION['Username'];
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
            echo "SQL ERROR";
        
        $params = array($institutionID, $teacherID);
        $options = array( "Scrollable" => 'static' );
        $CoursesQuery = "
        SELECT TC.CourseID, CT.CourseName, TC.Section, S.SessionName
        FROM Courses as TC, [CourseTypes] as CT, [SessionType] as S, SessionInstance as SI
        WHERE TC.InstitutionID = ? AND
	          TC.TeachingInstance = ? AND
		      CT.CourseTypeID = TC.CourseTypesID AND
		      SI.SessionInstanceID = TC.SessionInstanceID AND
              SI.SessionTypeID = S.ID
              GROUP BY TC.CoursesID, CT.CourseName, TC.Section, S.SessionName";
        $stmt = sqlsrv_query($con, $CoursesQuery, $params, $options);
        $length = 0;

        $courseID = [];
        $ClassNames = [];
        $Sections = [];
        $SessionNames = [];
        if ( $stmt === false)
            die( print_r( sqlsrv_errors(), true));
        while (sqlsrv_fetch( $stmt ) === true) 
        {
            $courseID[] = sqlsrv_get_field( $stmt, 0);
            $ClassNames[] = sqlsrv_get_field( $stmt, 1);
            $Sections[] = sqlsrv_get_field( $stmt, 2);
            $SessionNames[] = sqlsrv_get_field( $stmt, 3);
            $length++;
        }
        
        $params = array($teacherID);
        $institutionsQuery = "SELECT DISTINCT I.InstitutionName, I.InstitutionID FROM Institutions as I, TeachingInstance as TI WHERE TI.TeacherID = ? AND I.InstitutionID = TI.InstitutionID";
        $stmt = sqlsrv_query( $con, $institutionsQuery, $params, $options);
        if ($stmt === false)
            die (print_r(sqlsrv(errors(), true)));
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
                    <div class="row">
                        <div class="col-sm-8 col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    Filter Courses
                                </div>
                                <div class="panel-body">
                                    <form method="POST" action="" id="FilterCourses">
                                        <div class="form-group row">
                                            <div class="col-xs-6 col-md-4">
                                                <select class="form-control">
                                                <?php
        $i = 0;
        foreach($institutions as $inst)
        {
            if (($institutionID > 0) && ($institutionIDs[$i] == $institutionID))
            {
                ?>
                                                    <option value="<?=$institutionID?>" selected="selected"><?=$inst?></option>
                                                    <?php
            }
            else
            {
                ?>
                                                    <option value="<?=$institutionID?>"><?=$inst?></option>
                                                    <?php
            }
        }?>
                                                </select>
                                            
                                            </div>
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                            <tr>
                                                <td>Fall II 2014</td>
                                                <td>Entry</td>
                                                <td>1</td>
                                                <td><a href="ViewCourse/?cid=1">Course Page</a></td>
                                            </tr>
                                        <?php
        for ($i = 0; $i < $length; $i++)
        {
            echo "<tr>";
            echo "<td>$SessionNames[$i]</td>";
            echo "<td>$ClassNames[$i]</td>";
            echo "<td>$Sections[$i]</td>";
            echo "<td><a href='ViewCourse/?cid=$courseID[$i]'>Course Page</a></td>";
            echo "</tr>";

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
