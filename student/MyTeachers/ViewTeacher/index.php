<!-- View Teacher Profile page (index.html) for Student account -->
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
    if($_SESSION['Role'] != 'Student')
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
                    <div class="col-lg-9">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4>Teacher Info</h4>
                            </div>
                            <div class="panel-body">
                                <p>Name:</p>
                                <p>Institution(s):</p>
                                <p>Active with Smalltalk:</p>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-lg-9">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4>Recent Courses</h4>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Institution</th>
                                            <th>Course Number</th>
                                            <th>Course Name</th>
                                            <th>Session</th>
                                            <th>Course Page</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Gonzaga University</td>
                                            <td>ELCT 106</td>
                                            <td>Advanced Oral Communication</td>
                                            <td>Summer II 2013</td>
                                            <td><a href="/Student/MyCourses/ViewCourse/">Visit Course Page</a></td>
                                        </tr>
                                        <tr>
                                            <td>Gonzaga University</td>
                                            <td>ELCT 105</td>
                                            <td>Advanced Oral Communication</td>
                                            <td>Summer I 2013</td>
                                            <td>Not Enrolled</td>
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