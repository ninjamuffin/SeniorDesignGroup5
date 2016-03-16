<!-- View Worksheet (index.php) for Teacher account -->

<?php include "../../../../base.php"; ?>
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
                        <div class="col-xs-6">
                            <h1>Edit Worksheet<form method="POST" action="AnnotationEditor/" name="AnnotationEditorOpen" id="AnnotationEditorOpen">
                                <input hidden type="text" id="worksheetID" name="worksheetID">
                                <button class="btn-lg btn-primary" type="submit">Annotate</button>
                            </form></h1>
                        </div>
                        
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-sm-4">
                            <!-- Worksheet Info -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">Worksheet Details</div>
                                <div class="panel-body">
                                    <p>Topic:</p>
                                    <p>Date:</p>
                                    <p>Number of Sentences:</p>
                                </div> 
                            </div>
                        </div>
                        <div class="col-sm-8">
                            
                            <!-- Worksheet contents -->
                            <div class="panel panel-primary" style="min-height:400pxs;max-height-400px; overflow-y:scroll">
                                <div class="panel-heading">Worksheet Expressions</div>
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Student</th>
                                                <th>Expression</th>
                                                <th>Context/Vocab</th>
                                                <th>Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Name</td>
                                                <td>Expr</td>
                                                <td>Context is:</td>
                                                <td><span class="glyphicon glyphicon-star"></span></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Name</td>
                                                <td>Expr</td>
                                                <td>Context is:</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Name</td>
                                                <td>Expr</td>
                                                <td>Context is:</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- Student submissions -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">Submissions</div>
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Student</th>
                                                <th>Submission #</th>
                                                <th>Date</th>
                                                <th>Sentences Submitted</th>
                                                <th>Go To</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><a href="/Teacher/MyStudents/ViewStudentProfile/?sid=">Student</a></td>
                                                <td>First</td>
                                                <td>2/3/16</td>
                                                <td>14</td>
                                                <td>
                                                    <form method="POST" action="ViewSubmission/" id="viewsubmission" name="viewsubmission">
                                                        <input hidden type="text" value="1" id="submissionID" name="submissionID">
                                                        <button class="btn btn-primary" type="submit">View Submission</button>
                                                    
                                                    </form>
                                                </td>
                                                
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