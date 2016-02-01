<?php include "base.php"; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        
        <!-- Bootstrap -->
        <link href="/css/bootstrap.css" rel="stylesheet">
    </head>
    
    <?php
    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
    {
        if($_SESSION['Role'] == 'admin')
        {
            ?>
            <body>
            <div id="wrapper">
                <div id="sidebar-wrapper">
                    <u1 class="sidebar-nav">
                        <li class="sidebar-brand">
                            <a href="/Admin/Home/">Home</a>
                        </li>
                        <li class="sidebar-brand">
                            <a href="/Admin/ManageTeachers/">Manage Teachers</a>
                        </li>
                        <li class="sidebar-brand">
                            <a href="/Admin/ManageStudents/">Manage Students</a>
                        </li>
                        <li class="sidebar-brand">
                            <a href="/Admin/ManageCorpus/">Manage Corpus</a>
                        </li>
                        <li class="sidebar-brand">
                            <a href="/corpus/">Corpus</a>
                        </li>
                        <li class="sidebar-brand">
                            <a href="/Admin/Archive/">Archive</a>
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
        elseif($_SESSION['Role'] == 'teacher')
        {
            ?>
            <body>
            <div id="wrapper">
                <div id="sidebar-wrapper">
                    <u1 class="sidebar-nav">
                        
                        <li class="sidebar-brand">
                            <a href="/Teacher/Home/">Home</a>
                        </li>
                        <li class="sidebar-brand">
                            <a href="/Teacher/MyCourses/">My Courses</a>
                        </li>
                        <li class="sidebar-brand">
                            <a href="/corpus/">Corpus</a>
                        </li>
                        <li class="sidebar-brand">
                            <a href="/Teacher/Archive/">Archive</a>
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
        elseif($_SESSION['Role'] == 'student')
        {
            ?>
            <body>
            <div id="wrapper">
                <div id="sidebar-wrapper">
                    <u1 class="sidebar-nav">
                        
                        <li class="sidebar-brand">
                            <a href="/Student/Home/">Home</a>
                        </li>
                        <li class="sidebar-brand">
                            <a href="/Student/MyCourses/">My Courses</a>
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
    }                 
    <?php
    }
    else
       {
            ?>
            <!-- Reroute to log-in page if there is no session detected -->
            <meta http-equiv='refresh' content='0;index.php' />
            <?php
       }
    ?>    
</html>