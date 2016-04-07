<?php 
include "../../../../../../base.php";
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
    <link href="/flatUI/css/theme.css" rel="stylesheet" media="screen">

    <!-- Including Header -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="/js/SidebarPractice.js"></script>
    <script type="text/javascript" src="/js/getText.js"></script>
    <script>
        $(function(){
            $("#header").load("/header.php");
        });
        $(function(){
            $("#sidebar").load("/sidebar.php");
        });
    </script>
    <script>
        var selection = "<---------->";
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
        $courseID = isset($_GET['courseID']) ? $_GET['courseID'] : 0;
        $worksheetNum = isset($_GET['worksheetNum']) ? $_GET['worksheetNum'] : 0;
        if (false)
            echo "<meta http-equiv='refresh' content='0;../../' />";
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
                                <h3>Annotation Editor</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="panel panel-primary" style="min-height: 300px;max-height: 300px; overflow-y:auto">
                                    <div class="panel-heading">
                                        <h4>Worksheet Details</h4>
                                    </div>
                                    <div class="panel-body">
                                        <p>Course</p>
                                        <p>Date</p>
                                        <p>Topic</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="panel panel-primary" style="min-height: 300px;max-height: 300px; overflow-y:auto">
                                    <div class="panel-heading">
                                        <h4>Expressions List</h4>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Student</th>
                                                    <th>Expression</th>
                                                    <th>Context/Vocab</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td><a href="/Admin/Archive/Students/ViewStudent/?sid=">Name</a></td>
                                                    <td>Here's a expression</td>
                                                    <td>Some Context</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary" style="min-height: 600px;">
                                    <div class="panel-heading">
                                        <h4>Editor</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-xs-4" style="min-height:600px; border-right: 1px solid #1abc9c;">
                                            <!--Working here-->
                                            
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Expression</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            <div name="highlightrange">
                                                                Here's a expression
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>
                                                            <div name="highlightrange">
                                                                Another Expressions
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>
                                                            <div name="highlightrange">
                                                                Yet another expressive
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    
                                        <div class="col-xs-8">
                                            <h4>Expression Annotator</h4>
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#newedit">New Annotation</a></li>
                                                <li><a data-toggle="tab" href="#viewprevious">Previous Annotations</a></li>

                                            </ul>
                                            <div class="tab-content">
                                                <div id="newedit" class="tab-pane fade in active">
                                                    <div class="row">
                                                       <div class="col-xs-12">
                                                            <textarea disabled id="expression" class="form-control" class="col-xs-11">
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <select class="form-control">
                                                                <option selected="selected">--Error Type--</option>
                                                                <option>type1</option>
                                                                <option>type2</option>
                                                                <option>type3</option>
                                                                <option>type4</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <select class="form-control">
                                                                <option selected="selected">--Error Subselect--</option>
                                                                <option>type1</option>
                                                                <option>type2</option>
                                                                <option>type3</option>
                                                                <option>type4</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-xs-8">
                                                            <input type="text" class="form-control" name="Comments" id="Comments" placeholder="Comments">
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <button type="button" class="btn btn-primary">
                                                                Submit Annotation
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                            
                                                <div id="viewprevious" class="tab-pane fade">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <h4>Previous Annotations</h4>
                                                            <table class="table table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Date</th>
                                                                        <th>Author</th>
                                                                        <th>Text</th>
                                                                        <th>Error Category</th>
                                                                        <th>Error Name</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                    
                                        </div>
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
