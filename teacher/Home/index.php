<!-- Home (index.html) for Teacher account -->
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
        $username = $_SESSION['Username'];
        $role = $_SESSION['Role'];
        $params = array( $username, $role);
        $options = array( "Scrollable" => 'static' );
        $UserInfoQuery = "
        SELECT R.Designation 
        FROM RoleInstances as RI, Roles as R 
        WHERE  RI.SiteUsername = ? AND 
               R.Role = ? AND 
               R.RoleID = RI.RoleID";
        $stmt = sqlsrv_query($con, $UserInfoQuery, $params, $options);
        if ( $stmt === false)
            die( print_r( sqlsrv_errors(), true));
        $Designation = "";
        $Institution = "";
        if ( sqlsrv_fetch( $stmt ) === true)
        {
            $Designation = sqlsrv_get_field( $stmt, 0);
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
                            <div class="col-lg-10">
                                <h3>Firstname Lastname</h3>
                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        Teacher User Info:
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4><a href="/Teacher/MyCourses/">Active Courses</a></h4>
                                    </div>
                                    <div class="panel-body" style="min-height: 150px; max-height: 150px;overflow-y: scroll">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Course</th>
                                                    <th>Go To</th>
                                                </tr>
                                            </thead>
                                        
                                                
                                            <tbody>
                                                <tr>
                                                    <td>ELCT 101</td>
                                                    <td><a href="/Teacher/MyCourses/ViewCourse/?cid=">View Course</a></td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4><a href="/Teacher/MyStudents/">My Students</a></h4>
                                    </div>
                                    <div class="panel-body" style="min-height: 150px; max-height: 150px;overflow-y: scroll">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Go To</th>
                                                </tr>
                                            </thead>
                                        
                                                
                                            <tbody>
                                                <tr>
                                                    <td>Stu Dent</td>
                                                    <td><a href="/Teacher/MyStudents/ViewStudentProfile/">View Profile</a></td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-8">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4>My Site Activity Queue</h4>
                                    </div>
                                    <div class="panel-body" style="min-height: 250px;max-height: 250px;overflow-y: scroll">
                                        <form method="POST" id="filterActivityQueue" action="">
                                            <div class="form-group row">
                                                <div class="col-lg-3 col-md-3 col-sm-4">
                                                    <select class="form-control">
                                                        <option selected="selected">--Institution--</option>
                                                        <option>Gonzaga</option>
                                                        <option>Spokane Falls CC</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-4">
                                                    <select class="form-control" style="display:inline">
                                                        <option selected="selected">--Course--</option>
                                                        <option>Course Info</option>
                                                        <option>Course Info</option>
                                                        <option>Course Info</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-4">
                                                    <select class="form-control">
                                                        <option selected="selected">--Action Type--</option>
                                                        <option>Submitted Worksheet</option>
                                                        <option>Question</option>
                                                        <option>Submitted Other</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Filter Activity Queue</button>
                                            </div>
                                        </form>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Institution</th>
                                                    <th>Course</th>
                                                    <th>Action Type</th>
                                                    <th>User</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1/28/2016</td>
                                                    <td>Gonzaga University</td>
                                                    <td>Seminar: Spring I 2016</td>
                                                    <td><a href="/Teacher/MyCourses/ViewCourse/ViewWorksheet/ViewSubmission/">Worksheet Submission</a></td>
                                                    
                                                    <td><a href="/Teacher/MyStudents/ViewStudentProfile/">Student Name</a></td>
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
