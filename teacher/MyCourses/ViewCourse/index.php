<!-- Course view (index.php) for Teacher account -->

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
    <link href="/FlatUI/css/theme.css" rel="stylesheet">
    
    <!-- Including Header -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="/js/SidebarPractice.js"></script>
    <script>
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
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3>Course Info</h3>
                                </div>
                                <div class="panel-body">
                                    <p>Name:</p>
                                    <p>Institution:</p>
                                    <p>Session:</p>
                                    <p>Section:</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3>Students</h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Go To</th>
                                                <th>Go To (Archive)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Stu Dent</td>
                                                <td><a href="Students/ViewStudentProfile/">Student Page</a></td>
                                                <td><a href="/Teacher/Archive/Students/ViewStudent/?sid=">View in Archive</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-10 col-md-10">
                            <!-- Worksheet Listing -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">Worksheets</div>
                                
                                <div class="panel-body">
                                    <form method="POST" action="WorksheetEditor/" name="NewWorksheet">
                                        <div class="form-group row">
                                            <div class="col-xs-4 col-sm-3">
                                                <input type="hidden" name="Number" value="1">
                                                <button class="btn btn-primary" type="submit"</button>
                                            </div>
                                        </div>
                                    </form>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Go To</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>3</td>
                                                <td>3/4/2016</td>
                                                <td>In Progress</td>
                                                <td><a href="WorksheetEditor/?wid=">Edit Worksheet</a></td>
                                                <td><button class="btn btn-primary" type="button"><a href="#">Publish</a></button></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>2/27/2016</td>
                                                <td>In Progress</td>
                                                <td><a href="WorksheetEditor/?wid=">Edit Worksheet</a></td>
                                                <td><button class="btn btn-primary" type="button"><a href="#">Publish</a></button></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>3/4/2016</td>
                                                <td>Published</td>
                                                <td><a href="ViewWorksheet/?wid=">View Worksheet</a></td>
                                                <td><button class="btn btn-primary" disabled type="button"><a>Published</a></button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            
                            <!-- END PAGE CONTENT -->
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