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
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3>Gonzaga Smalltalk Corpus</h3>
                                    </div>
                                    <div class="panel-body">
                                        <p>Date: </p>
                                        <p>Total Additions This Month:</p>
                                        <p>From Gonzaga University This Month:</p>
                                        <p>Expressions in the Corpus:</p>
                                        <p>Number of Contributors:</p>
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-5 col-md-5 col-sm-6">
                                <div class="panel panel-primary" style="min-height: 310px;max-height: 310px;">
                                    <div class="panel-heading">
                                        <h4>Corpus Administrators</h4>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <td>Institution</td>
                                                    <td>Name</td>
                                                    <td>Role</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Gonzaga University</td>
                                                    <td>Fname Lname</td>
                                                    <td>Graduate Student</td>
                                                </tr>
                                            </tbody>
                                        </table>  
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-lg-9 col-md-9">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4>Corpus Additions</h4>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Institution</th>
                                                    <th>Contributor</th>
                                                    <th>Submission Title</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>2/20/16</td>
                                                    <td>Gonzaga</td>
                                                    <td>Teacher Name</td>
                                                    <td><a href="ReviewSubmission/">Worksheet Submission</a></td>
                                                    <td>Approved</td>
                                                </tr>
                                                <tr>
                                                    <td>2/20/16</td>
                                                    <td>Gonzaga</td>
                                                    <td>Teacher Name</td>
                                                    <td><a href="ReviewSubmission/">Worksheet Submission</a></td>
                                                    <td><button class="btn btn-primary">Approve</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                                
</p>
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
                e.preventhefault();
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
