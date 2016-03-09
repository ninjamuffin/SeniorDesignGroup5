<!-- Page for the admin user to oversee current courses, and navigate to CreateCourse -->
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
                            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                <h1>Courses</h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-10">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Add New Course</div>
                                    <div class="panel-body">
                                         <form method="POST" id="filterActivityQueue" action="">
                                            <div class="form-group row">
                                                
                                                <div class="col-lg-4">
                                                    <select class="form-control" name="Session">
                                                        <option selected="selected">--Session--</option>
                                                        <option>Fall I 2015</option>
                                                        <option>Fall II 2015</option>
                                                        <option>Summer I 2015</option>
                                                        <option>Summer II 2015</option>
                                                        <option>Spring I 2016</option>
                                                        <option>Spring II 2016</option>
                                                    
                                                    </select>
                                                </div>
                                                <div class="col-lg-4">
                                                    <select class="form-control" name="CourseName" id="CourseName">
                                                        <option selected="selected">--Level--</option>
                                                        <option>Entry</option>
                                                        <option>Basic</option>
                                                        <option>Intermediate</option>
                                                        <option>Advanced</option>
                                                        <option>Seminar</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4">
                                                    <select class="form-control" name="Section" id="Section">
                                                        <option selected="selected">--Section--</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                    </select>
                                                </div>
                                                
                                                
                                            </div>
                                             <div class="form-group row" style="padding-right: 15px;">
                                                 <div class="col-lg-9">
                                                    <input class="form-control" type="text" name="SelectTeacher" id="SelectTeacher" placeholder="Teacher" />
                                                 </div>
                                                    <button type="submit" class="btn btn-primary pull-right">Create Course</button>
                                             </div>
                                             
                                        </form>
                                    </div>
                                </div>       
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-10">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Active Courses</div>
                                    <div class="panel-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <td>Institution</td>
                                                    <td>Session Name</td>
                                                    <td>Course Name</td> <!-- Link to page -->
                                                    <td>Section</td>
                                                    <td>Teacher Name</td> <!-- Link to page -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Gonzaga University</td>
                                                    <td>Fall II 2014</td>
                                                    <td>Advanced...</td>
                                                    <td>1</td>
                                                    <td>Hunter</td>
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
