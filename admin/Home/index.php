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
        $username = $_SESSION['Username'];
        $role = $_SESSION['Role'];
        $params = array( $username, $username);
        $options = array( "Scrollable" => 'static' );
        $UserInfoQuery = "
        SELECT R.Designation, I.InstitutionName
        FROM RoleInstances as RI, Roles as R, Administrators as A, Institutions as I
        WHERE  RI.SiteUsername = ? AND
	           R.RoleID = RI.RoleID AND
		       R.Role = 'Admin' AND
		       A.SiteUsername = ? AND
		       I.InstitutionID = A.InstitutionID";
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
                            <div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3>Administrator Home</h3>
                                    </div>
                                    <div class="panel-body">
                                        <p><?=$_SESSION['FirstName']?> <?=$_SESSION['LastName']?></p>
                                        <p>Role: <?=$Designation?> Admin</p>
                                        <p>Institution: <?=$Institution?></p>
                                    </div>
                                </div> 
                            </div>
                        <?php
        $params = array($_SESSION['Username'], $_SESSION['Role']);
        $options = array( "Scrollable" => 'static' );
        $AdminTypeQuery = "
        SELECT R.Type FROM Roles as R, RoleInstances as RI WHERE RI.SiteUsername = ? AND R.RoleID = RI.RoleID AND R.Role = ?";
        $stmt = sqlsrv_query($con, $AdminTypeQuery, $params, $options);
        if ($stmt === false)
            die (print_r(sqlsrv_errors(), true));
        if (sqlsrv_fetch( $stmt ) === true)
            $adminType = sqlsrv_get_field ($stmt, 0);
        echo $adminType;
                            <div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4>All Site Administrators</h4>
                                    </div>
                                    <div class="panel-body" style="min-height: 150px; max-height: 150px;overflow-y: scroll">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Institution</th>
                                                    <th>Name</th>
                                                    <th>Designation</th>
                                                </tr>
                                            </thead>
                                            
                                            <?php
        $params = array();
        $options = array( "Scrollable" => 'static');
        $adminsQuery = "
        SELECT I.InstitutionName, A.FirstName, A.LastName, R.Designation
        FROM Institutions as I, Administrators as A, RoleInstances as RI, Roles as R
        WHERE A.RoleInstanceID = RI.RoleInstanceID AND
              RI.RoleID = R.RoleID AND
              R.Role = 'Admin' AND
              I.InstitutionID = A.InstitutionID";
        $stmt = sqlsrv_query($con, $adminsQuery, $params, $options);
        if ($stmt === false)
            die(print_r(sqlsrv_errors(), true));
        while (sqlsrv_fetch($stmt) === true)
        {
            $institution = sqlsrv_get_field($stmt, 0);
            $fname = sqlsrv_get_field($stmt, 1);
            $lname = sqlsrv_get_field($stmt, 2);
            $designation = sqlsrv_get_field($stmt, 3);
            
            echo "<tr>";
            echo "<td>$institution</td>";
            echo "<td>$fname $lname</td>";
            echo "<td>$designation</td>";
        }
        ?>
                                                
                                            <tbody>
                                                
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4><?=$Institution?> Activity Queue</h4>
                                    </div>
                                    <div class="panel-body" style="min-height: 250px;max-height: 250px;overflow-y: scroll">
                                        <form method="POST" id="filterActivityQueue" action="">
                                            <div class="form-group row">
                                                <div class="col-lg-3">
                                                    <select class="form-control">
                                                        <option selected="selected">--Author Type--</option>
                                                        <option>Primary Admin</option>
                                                        <option>Assistant Admin</option>
                                                        <option>Graduate Student</option>
                                                        <option>Teacher</option>
                                                        <option>Student</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <select class="form-control" style="display:inline">
                                                        <option selected="selected">--Action Type--</option>
                                                        <option>Create</option>
                                                        <option>Distribute</option>
                                                        <option>Complete</option>
                                                        <option>Annotate</option>
                                                        <option>Insert</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <select class="form-control">
                                                        <option selected="selected">--Object Type--</option>
                                                        <option>Corpus/Archive Expression</option>
                                                        <option>Worksheet</option>
                                                        <option>Class</option>
                                                        <option>User</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Apply Filter</button>
                                            </div>
                                        </form>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Action Name</th>
                                                    <th>Action Type</th>
                                                    <th>User</th>
                                                </tr>
                                            </thead>
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
            <script type="text/javascript" src="/js/SidebarPractice.js"></script>
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
