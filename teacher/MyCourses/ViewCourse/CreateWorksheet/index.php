<!-- Create Worksheet (index.php) for Teacher account -->

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
        <div id="header"></div>
        <div id="wrapper">
            <div id = "sidebar"></div>
            <div id="page-content-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                        <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                            <span class="hamb-top"></span>
                            <span class="hamb-middle"></span>
                            <span class="hamb-bottom"></span>
                        </button>
                            <!-- BEGIN PAGE CONTENT -->
                            <h1>Course Title: Create Worksheet #</h1>
                            <div class="panel panel-primary">
                                <div class="panel-heading">Enter Worksheet Information</div>
                                <div class="panel-body">
                                    <p>Enter <strong>topic</strong>, enter <strong>date</strong>, verify <strong>level</strong> (extracted from course number)</p>
                                </div> 
                            </div>
    
                            <div class="well">
                            <form id="Worksheet" method="post" action="#submit-expression" class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-xs-3">
                                        <form action="">
                                        Student: <input type="text" onkeyup="showHint(this.value)"></form>
                                        <p>Suggestions: <span id="txtHint"></span></p>
                                    </div>
                                    <!--<div class="col-xs-6">
                                        <input type="text" class="form-control" name="Expression" placeholder="Enter Expression" />
                                    </div>
                                    <div class="col-xs-3">
                                        <input type="text" class="form-control" name="Expression" placeholder="Context/Vocab" />
                                    </div>
                                <div class="col-xs-1">
                                    <button type="button" class="btn btn-default"></button>
                                </div>    -->
                                </div>
                            </form>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">Expression Template</div>
                                <div class="panel-body">
                                    <p>Sentence number, Dropdown{Select Student}, Text Entry{Enter Expression}, Text Entry{Enter Context/Vocab}, Submit</p>
                                    <p>On submit: disable submit, print "Submitted"</p>
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
        <script>
       
        function showHint(str) {
            if (str.length == 0) { 
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET", "ChangeRole.php?q=" + str, true);
                xmlhttp.send();
            }
        }
        
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