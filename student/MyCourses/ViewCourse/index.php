<!-- View Course (index.html) for basic Student account -->
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
            $("#header").load("/header.html");
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
                    <div class="col-lg-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3>Course Info</h3>
                            </div>
                            <div class="panel-body">
                                <p>Course Number: ELCT 101</p>
                                <p>Course Title: Basic Oral Communication</p>
                                <p>Session: Fall II 2015</p>
                                <p>Teacher: Hunter</p>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-primary" style="min-height: 300px;max-height: 300px; overflow-y: scroll">
                            <div class="panel-heading">
                                <h3>Course Activity Queue</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Go To</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1/3/2016</td>
                                            <td>New Worksheet</td>
                                            <td>Not yet viewed</td>
                                            <td><a href="#">View Worksheet</a></td>
                                        </tr>
                                        <tr>
                                            <td>1/10/2016</td>
                                            <td>Feedback posted</td>
                                            <td>Viewed</td>
                                            <td><a href="#">View Feedback</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-lg-9">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4>Worksheets</h4>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Worksheet Number</th>
                                            <th>Date</th>
                                            <th>Topic</th>
                                            <th>Status</th>
                                            <th>Feedback</th>
                                            <th>Open Editor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Fake Data -->
                                        <tr>
                                            <td>1</td>
                                            <td>2/2/2016</td>
                                            <td>The Futility of Hope</td>
                                            <td>Submitted</td>
                                            <td><a href="#">See Feedback</a></td>
                                            <td><a href="ViewWorksheet/">View Worksheet</a></td>

                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2/9/2016</td>
                                            <td>Optimism</td>
                                            <td>Submitted</td>
                                            <td>Not available</td>
                                            <td><a href="ViewWorksheet/">View Worksheet</a></td>

                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>3/1/2016</td>
                                            <td>Politics</td>
                                            <td>Not Submitted</td>
                                            <td>N/A</td>
                                            <td><a href="WorksheetEditor/">Edit Worksheet</a></td>
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