<!-- Home (index.html) for basic Admin account -->
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
        
        <!-- Including Header -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script>
            $(function(){
                $("#header").load("/header.php");
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

<body>
    <div id="header"></div>
    <div class="col-sm-12">
        <!-- Name-plate for teacher homepage. Identifies which instructor is logged in. -->
        <div class="container">
            <h1>Administrator Name</h1>
            <p>Documentation:</p>
                <p>Page provides admin user home.  Eventual content will be a site activity queue, listing all teacher/student actions in chronological order.  Will eventually handle requests for corpus changes from teacher members</p>
                <p>Sidebar will include admin navigation: ManageStudents, ManageTeachers, ManageCorpus, Archive</p>
                <p>Nav bar will include basic account access (same regardless of role)</p>
                <a href="/header.php"></a>
        </div>
    </div>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/bootstrap-datepicker.js"></script>
</body>
</html>
