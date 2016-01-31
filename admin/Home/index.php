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
    <link href="/css/simple-sidebar.css" rel="stylesheet">


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

<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
    if($_SESSION['Role'] != 'admin')
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
                <div id="sidebar-wrapper">
                    <u1 class="sidebar-nav">
                        <li class="sidebar-brand">
                            <a href="/Admin/Home/index.php">Home</a>
                        </li>
                        <li class="sidebar-brand">
                            <a href="/Admin/ManageTeachers/index.php">Manage Teachers</a>
                        </li>
                        <li class="sidebar-brand">
                            <a href="/Admin/ManageStudents/index.php">Manage Students</a>
                        </li>
                        <li class="sidebar-brand">
                            <a href="/ManageCorpus/index.php">Manage Corpus</a>
                        </li>
                        <li class="sidebar-brand">
                            <a href="/corpus/index.php">Archive</a>
                        </li>

                        <li class="sidebar-brand">
                            <a href="#">Help</a>
                        </li>

                    </u1>    


                </div>
                <div id="sidebar-content-wrapper">
                    <div class="col-sm-12">
                        <div class="container">
                            <h1>Administrator Name</h1>
                            <p>Documentation:</p>
                                <p>Page provides admin user home.  Eventual content will be a site activity queue, listing all teacher/student actions in chronological order.  Will eventually handle requests for corpus changes from teacher members</p>
                                <p>Sidebar will include admin navigation: ManageStudents, ManageTeachers, ManageCorpus, Archive</p>
                                <p>Nav bar will include basic account access (same regardless of role)</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="/js/bootstrap.min.js"></script>
            <script src="/js/bootstrap-datepicker.js"></script>
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
    <p>Click <a href="/index.php">here</a> if you don't want to wait</p>
    <?php
}
?>

</html>
