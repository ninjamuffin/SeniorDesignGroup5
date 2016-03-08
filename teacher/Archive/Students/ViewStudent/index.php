<?php 
include "../../../../base.php";
?>
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
        $studentID = isset($_GET['sid']) ? $_GET['sid'] : 0;
        if ($studentID == 0)
            echo "<meta http-equiv='refresh' content=0;../";
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
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Student Information</div>
                                    <div class="panel-body">
                                        <p>Last Active Session:</p>
                                        <p>Joined SmallTalk:</p>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">        
                                <div class="panel panel-primary" style="min-height: 300px;max-height: 300px; overflow-y: scroll">
                                    <div class="panel-heading">
                                        Statistics
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-lg-10 col-md-10">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Courses</div>
                                    <div class="panel-body">
                                        <form>
                                            <p>Filter Courses:</p>
                                            <div class="form-group row">
                                                <div class="col-lg-3">
                                                    <input class="form-control" type="text" name="Session" id="Session" placeholder="Session">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                    <button class="btn btn-primary" type="submit">Apply Filter</button>
                                            
                                                </div>
                                            </div>
                                        </form>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Session</th>
                                                    <th>Level</th>
                                                    <th>Go To</th>
                                                    <th>Annotation Editor</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Fall I 2012</td>
                                                    <td>Basic</td>
                                                    
                                                    <td><a href="/Teacher/Archive/Courses/ViewCourse/ViewWorksheet/?CourseID=1&WorksheetNum=1">View Worksheet</a></td>
                                                    <td><a href="/Teacher/Archive/Courses/ViewCourse/ViewWorksheet/AnnotationEditor?CourseID=1&worksheetNum=1">Annotation Editor</a></td>

                                                </tr>
                                                <tr>
                                                    <td>Fall II 2012</td>
                                                    <td>Intermediate</td>
                                                
                                                    <td><a href="/Teacher/Archive/Courses/ViewCourse/ViewWorksheet/?CourseID=1&WorksheetNum=1">View Worksheet</a></td>
                                                    <td><a href="/Teacher/Archive/Courses/ViewCourse/ViewWorksheet/AnnotationEditor?CourseID=1&worksheetNum=1">Annotation Editor</a></td>
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
