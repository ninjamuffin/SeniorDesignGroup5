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
                                <h2>Firstname Lastname</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-3">
                                <div class="panel panel-primary" style="min-height:280px;max-height:280px">
                                    <div class="panel-heading">
                                        <h3>Teacher Information</h3>
                                    </div>
                                    <div class="panel-body">
                                        <p>Institution:</p>
                                        <p>Joined SmallTalk:</p>
                                        <p>Last Active Session:</p>
                                        <p>Number of SmallTalk<br /> Courses:</p>
                                    </div>
                                </div>   
                            </div>
                            <div class="col-lg-7 col-md-7">
                                <div class="panel panel-primary" style="min-height:280px;max-height:280px;overflow-y:scroll">
                                    <div class="panel-heading">
                                        <h3>Courses</h3>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Course Number</th>
                                                    <th>Course Name</th>
                                                    <th>Session</th>
                                                    <th>Status</th>
                                                    <th>Go To</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>ELCT 107</td>
                                                    <td>Communications Seminar</td>
                                                    <td>Fall I 2015</td>
                                                    <td>Archived</td>
                                                    <td><a href="/Admin/Archive/Courses/ViewCourse/">View Course</a></td>
                                                </tr>
                                                <tr>
                                                    <td>ELCT 107</td>
                                                    <td>Communications Seminar</td>
                                                    <td>Spring II 2016</td>
                                                    <td>Active</td>
                                                    <td><a href="/Admin/ManageCourses/ViewCourse/">View Course</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>   
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-10 col-md-10">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3>Teacher Activity </h3>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Course Name</th>
                                                    <th>Active Session</th>
                                                    <th>Action Name</th>
                                                    <th>Go To</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1/1/2016</td>
                                                    <td>Basic Oral Communication</td>
                                                    <td>Spring I 2016</td>
                                                    <td>Distributed Worksheet</td>
                                                    <td><a href="/Admin/Archive/Courses/ViewCourse/ViewWorksheet/">View Worksheet</a></td>
                                                </tr>
                                                <tr>
                                                    <td>1/8/2016</td>
                                                    <td>Basic Oral Communication</td>
                                                    <td>Spring I 2016</td>
                                                    <td>Submitted Worksheet to Corpus</td>
                                                    <td><a href="/Admin/ManageCorpus/ReviewSubmission/">View Submission</a></td>
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
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="/js/bootstrap.min.js"></script>
            <script src="/js/bootstrap-datepicker.js"></script>
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
    <p>Click <a href="/index.php">here</a> if you don't want to wait</p>
    <meta http-equiv='refresh' content='5;/index.php' />
    <?php
}
?>

</html>
