<!-- View student profile (index.php) for Teacher account -->

<?php include "../../../../../base.php"; ?>
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
    <link href="/FlatUI/css/theme.css" rel="stylesheet">
    
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
                        <div class="col-lg-4 col-md-6">
                            <div class="panel panel-primary" style="min-height:250px;max-height:250px">
                                <div class="panel-heading">
                                    <h4>Student Info</h4>
                                </div>
                                <div class="panel-body">
                                    <p>Name:</p>
                                    <p>Institution:</p>
                                    <p>Courses completed:</p>
                                    <p>Sessions Active in Smalltalk:</p>
                                </div>
                                    
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="panel panel-primary" style="min-height:250px;max-height:250px;overflow-y:scroll">
                                <div class="panel-heading">
                                    <h4>Courses Taken</h4>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Course Name</th>
                                                <th>Instructor</th>
                                                <th>Status</th>
                                                <th>Go To</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>ELCT 101</td>
                                                <td>Hunter</td>
                                                <td>Completed</td>
                                                <td><a href="/Teacher/Archive/Courses/ViewCourse/">Course in Archive</a></td>
                                            </tr>
                                            <tr>
                                                <td>ELCT 102</td>
                                                <td>Teacher Name</td>
                                                <td>Ongoing</td>
                                                <td><a href="/Teacher/MyCourses/ViewCourse/">View My Course</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                    
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-10">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    Submitted Worksheets
                                </div>
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Course Name</th>
                                                <th>Worksheet Number</th>
                                                <th>Performance</th>
                                                <th>Go To</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>ELCT 102</td>
                                                <td>2</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-info" style="width: 80%">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><a href="/Teacher/MyCourses/ViewCourse/ViewWorksheet/ViewSubmission/?subid=">View Submission</a></td>
                                            </tr>
                                            <tr>
                                                <td>ELCT 102</td>
                                                <td>1</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-info" style="width: 100%">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><a href="/Teacher/MyCourses/ViewCourse/ViewWorksheet/ViewSubmission/?subid=">View Submission</a></td>
                                            </tr>
                                            <tr>
                                                <td>ELCT 101</td>
                                                <td>3</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-info" style="width: 90%">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><a href="/Teacher/Archive/Courses/ViewCourse/ViewWorksheet/?wid=">Worksheet in Archive</a></td>
                                            </tr>
                                            <tr>
                                                <td>ELCT 101</td>
                                                <td>2</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-info" style="width: 100%">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><a href="/Teacher/Archive/Courses/ViewCourse/ViewWorksheet/?wid=">Worksheet in Archive</a></td>
                                            </tr>
                                            <tr>
                                                <td>ELCT 101</td>
                                                <td>1</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-info" style="width: 50%">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><a href="/Teacher/Archive/Courses/ViewCourse/ViewWorksheet/?wid=">Worksheet in Archive</a></td>
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

