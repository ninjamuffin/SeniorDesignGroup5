<!-- Edit Worksheet page (index.html) for Student account -->
<?php include "/base.php"; ?>
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
    <link href="/css/datepicker.css" rel="stylesheet">
    <link href="/css/simple-sidebar.css" rel="stylesheet">
    <link rel="stylesheet/less" type="text/css" href="/datepicker.less" />

    <!-- Including Header -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>
        $(function(){
            $("#header").load("/header.html");
        });
        $(function(){
            $("#sidebar").load("/sidebar.php");
        });
    </script>

    <!-- Background Setup -->
    <style>
        body{
            background: url(/media/gonzagasmalltalk_background.png) no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: auto;
        }
    </style>
</head>
        
<?php
session_start();
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
    if($_SESSION['Role'] != 'student')
    {
        ?>
        <p>You do not have permission to view this page.  Redirecting in 5 seconds</p>
        <p>Click <a href="/index.php">here</a> if you don't want to wait</p>
        <meta http-equiv='refresh' content='5;/index.php' />
        <?php
    }
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
                        <!-- BEGIN PAGE CONTENT -->
                        <h2>Documentation:</h2>
                        <p>For the student, this will provide an editing window/form that the student will fill out.  The contents of this page will allow for text as well as audio data entry, and will eventually contain a speech to text module.  Students will be permitted to submit multiple versions of the assignment, and this tracking data will be both displayed in the window and entered in with each new submission</p>
                        <p> Standard navbars</p>
        
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
        <script src="/js/bootstrap-datepicker.js"></script>
      </body>
</html>