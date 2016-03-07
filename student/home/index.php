<!-- Home (index.html) for basic Student account -->
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
    if($_SESSION['Role'] != 'Student')
    {
        ?>
        <p>You do not have permission to view this page.  Redirecting in 5 seconds</p>
        <p>Click <a href="/">here</a> if you don't want to wait</p>
        <meta http-equiv='refresh' content='5;/' />
        <?php
    }
    else
    { $username = $_SESSION['Username'];
        $role = $_SESSION['Role'];
        $params = array( $username, $role);
        $options = array( "Scrollable" => 'static' );
        $UserInfoQuery = "
        SELECT R.Designation, I.InstitutionName
        FROM RoleInstances as RI, Roles as R, Institutions as I, Students as S
        WHERE  RI.SiteUsername = ? AND
	           R.RoleID = RI.RoleID AND
		       R.Role = ? AND
		       I.InstitutionID = S.InstitutionID";
        $stmt = sqlsrv_query($con, $UserInfoQuery, $params, $options);
        if ( $stmt === false)
            die( print_r( sqlsrv_errors(), true));
        $Designation = "";
        $Institution = "";
        if ( sqlsrv_fetch( $stmt ) === true)
        {
            $Designation = sqlsrv_get_field( $stmt, 0);
            $Institution = sqlsrv_get_field( $stmt, 1);
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
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h1>Student Home</h1>
                                    </div>
                                    <div class="panel-body">
                                        <p><?=$_SESSION['FirstName']?> <?=$_SESSION['LastName']?></p>
                                        <p>Role:  Student <small class="text-muted"><?=$Designation?></small></p>
                                        <p>Institution: <?=$Institution?></p>
                                    </div>
                                </div> 
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4><a href="/Student/MyCourses/">My Courses </a></h4>
                                            
                                            
                                    </div>
                                    <div class="panel-body" style="min-height: 150px; max-height: 150px;overflow-y: scroll">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Course Name</th>
                                                    <th>Teacher</th>
                                                    <th>Session</th>
                                                    
                                                </tr>
                                            </thead>
                                                
                                            <tbody>
                                                
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4>My Activity Queue</h4>
                                    </div>
                                    <div class="panel-body" style="min-height: 250px;max-height: 250px;overflow-y: scroll">
                                        
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Course Name</th>
                                                    <th>Action Type</th>
                                                    <th>Status</th>
                                                    <th>Link</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>2/1/2016</td>
                                                    <td>101 A</td>
                                                    <td>New Worksheet Posted</td>
                                                    <td class="text-danger">Incomplete</td>
                                                    <td><button class="btn btn-primary" href="/Student/MyCourses/ViewCourse/WorksheetEditor/">Complete it</button></td>
                                                </tr>
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
