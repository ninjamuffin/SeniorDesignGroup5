<?php include "../../../base.php"; ?>
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
    if( !( ($_SESSION['Role'] == 'Admin') && $_SESSION['AccessType'] == 'Super'))
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
                            <div class="col-lg-3 col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3>Gonzaga University</h3>
                                    </div>
                                    <div class="panel-body">
                                        <p>City:</p>
                                        <p>State:</p>
                                        <p>Country:</p>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        Teachers
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Go To</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>James Hunter</td>
                                                    <td><a href="/Admin/ManageTeachers/ViewTeacherProfile/">Teacher Page</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-xs-10">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        Term Sessions
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-hover" id="institutions">
                                            <thead>
                                                <tr>
                                                    <th>Session Name</th>
                                                    <th>Default Start</th>
                                                    <th>Default End</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Fall I</td>
                                                    <td><a href="#" data-pk="1">September 1</a></td>
                                                    <td><a href="#" data-pk="2">October 20</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Fall II</td>
                                                    <td><a href="#" data-pk="4">October 21</a></td>
                                                    <td><a href="#" data-pk="3">December 14</a></td>
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
            <script type="text/javascript" src="/js/SidebarPractice.js"></script>
            <link href="/css/bootstrap/bootstrap-editable.css" rel="stylesheet">
            <script src="/js/bootstrap-editable.js"></script>
            <script>
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });
            </script>
            <script type="text/javascript">
            $('#institutions a').editable({
                type: 'text',
                name: 'date',
                url: '/post',
                title: 'Enter date'
            });

            //ajax emulation
            $.mockjax({
                url: '/post',
                responseTime: 200
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
