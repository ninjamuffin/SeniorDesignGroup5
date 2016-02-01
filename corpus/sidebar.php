<?php include "/base.php"; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        
        <!-- Bootstrap -->
        <link href="/css/bootstrap.css" rel="stylesheet">
        <link href="/css/simple-sidebar.css" rel="stylesheet">
    </head>
    
    <?php
    session_start();
    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
    {
        if( ($_SESSION['Role'] == 'admin') || ($_SESSION['Role'] == 'teacher') )
        {
            ?>
            <body>
            <div id="wrapper">
                <div id="sidebar-wrapper">
                    <u1 class="sidebar-nav">
                        <li class="sidebar-brand">
                            <a href="/<?=$_SESSION['Role']?>/Home/">Home</a>
                        </li>
                        <li class="sidebar-brand">
                            <a href="#">Tag Search</a>
                        </li>
                        <li class="sidebar-brand">
                            <a href="#">Annotation Editor</a>
                        </li>
                        <li class="sidebar-brand">
                            <a href="#">Graphical Analysis</a>
                        </li>

                        <li class="sidebar-brand">
                            <a href="#">Help</a>
                        </li>

                    </u1>    

                </div>
            </div>
            </body>
        <?php
        }
        else
        {
            ?>
            
            <!-- Reroute to log-in page if there bad log-in detected -->
            <meta http-equiv='refresh' content='5;/' />
            <p>Your account does not have authorization to view this page.</p>
            <p>Rerouting to your home page.  Click <a href='/'>here</a> if you don't want to wait.</p>
            <?php
            
        }                 
    }
    else
    {
        ?>
        <meta http-equiv="refresh" content='0;/' />
        <?php
    }
    ?>    
</html>