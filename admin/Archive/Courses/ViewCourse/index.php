<?php 
include "../../../base.php"; 
include "../../../pagination.php";
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


    <!-- Including Header -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>
        $(function(){
            $("#header").load("/header.php");
        });
        $(function(){
            $("#sidebar").load("/sidebar.php");
        });
    </script>

    <!-- Background Setup -->
    <style>
        body{
            background: url(/Media/gonzagasmalltalk_background.png) no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: auto;
        }
    </style>
</head>

<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
    if($_SESSION['Role'] != 'admin')
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
        if ($courseID == 0)
            echo "<meta http-equiv='refresh' content=0;";
        else
        {
        ?>
        <body>
            <div id="header"></div>           
            <div id="wrapper">
                <div id="sidebar"></div>
                <div id="page-content-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Collapse/Expand</a>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Documentation</div>
                                    <div class="panel-body">
                                        <p>Main course (archived) view for admin/teacher.  Will contain list/links to worksheets, students, and the teacher</p>
                                        <p>This top section will contain general information about a given course (teacher, level, etc)</p>
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Worksheet display</div>
                                    <div class="panel-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <td>Worksheet Number</td>
                                                    <td>Link</td>
                                                </tr>
                                            </thead>
                                            <tbody>
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
