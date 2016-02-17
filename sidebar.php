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
        <link href="css/SidebarPractice.css" rel="stylesheet">
        <link rel="stylesheet/less" type="text/css" href="/datepicker.less">
    </head>
    
    <?php
    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
    {
        if($_SESSION['Role'] == 'admin')
        {
            ?>
            <body>
                <div id="wrapper">
                    <div class="overlay"></div>

                    <!-- Sidebar -->
                    <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
                        <ul class="nav sidebar-nav">
                            <li class="sidebar-brand">
                                <a href="/Admin/Home/">Admin Home</a>
                            </li>
                            <li class="dropdown">
                              <a href="/admin/ManageCourses/" class="dropdown-toggle" data-toggle="dropdown">Manage Courses<span class="caret"></span></a>
                              <ul class="dropdown-menu" role="menu">
                                <li class="dropdown-header">Options</li>
                                <li><a href="/Admin/ManageCourses/CreateCourse/">   Create Course</a></li>
                                <li><a href="/Admin/ManageCourses/ViewCourse/"> View Course</a></li>
                              </ul>
                            </li>
                            <li class="dropdown">
                              <a href="/admin/ManageTeachers/" class="dropdown-toggle" data-toggle="dropdown">Manage Teachers<span class="caret"></span></a>
                              <ul class="dropdown-menu" role="menu">
                                <li class="dropdown-header">Options</li>
                                <li><a href="/Admin/ManageTeachers/CreateTeacher/"> Create Teacher</a></li>
                                <li><a href="/admin/ManageTeachers/ViewTeacherProfile/">    View Teacher Profile</a></li>
                              </ul>
                            </li>
                            <li class="dropdown">
                              <a href="/admin/ManageStudents/" class="dropdown-toggle" data-toggle="dropdown">Manage Students<span class="caret"></span></a>
                              <ul class="dropdown-menu" role="menu">
                                <li class="dropdown-header">Options</li>
                                <li><a href="/admin/ManageStudents/CreateStudent/"> Create Student</a></li>
                                <li><a href="/admin/ManageStudents/ViewStudentProfile/">    View Student Profile</a></li>
                              </ul>
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
                        </ul>
                    </nav>
                    <!-- /#sidebar-wrapper -->

                    <!-- Page Content -->
                    <div id="page-content-wrapper">
                        <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                            <span class="hamb-top"></span>
                            <span class="hamb-middle"></span>
                            <span class="hamb-bottom"></span>
                        </button>
                    </div>
                    <!-- /#page-content-wrapper -->
                </div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
                <!-- Include all compiled plugins (below), or include individual files as needed -->
                <script src="js/bootstrap.min.js"></script>
                <script type="text/javascript" src="js/SidebarPractice.js"></script>
                <script>
                $("#menu-toggle").click(function(e) {
                    e.preventDefault();
                    $("#wrapper").toggleClass("toggled");
                });
                </script>
            </body>
        <?php
        }
        elseif($_SESSION['Role'] == 'teacher')
        {
            ?>
            <body>
                <div id="wrapper">
                    <div class="overlay"></div>

                    <!-- Sidebar -->
                    <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
                        <ul class="nav sidebar-nav">
                            <li class="sidebar-brand">
                                <a href="/teacher/Home/">Teacher Home</a>
                            </li>
                            <li class="dropdown">
                              <a href="/teacher/MyInstitutions/" class="dropdown-toggle" data-toggle="dropdown">My Institutions<span class="caret"></span></a>
                              <ul class="dropdown-menu" role="menu">
                                <li class="dropdown-header">Options</li>
                                <li><a href="/teacher/MyInstitutions/MyCourses/">   My Courses</a></li>
                                <li><a href="/teacher/MyInstitutions/MyStudents/">  My Students</a></li>
                              </ul>
                            </li>
                            <li class="sidebar-brand">
                                <a href="/corpus/">Corpus</a>
                            </li>
                            <li class="sidebar-brand">
                                <a href="/teacher/Archive/">Archive</a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /#sidebar-wrapper -->

                    <!-- Page Content -->
                    <div id="page-content-wrapper">
                        <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                            <span class="hamb-top"></span>
                            <span class="hamb-middle"></span>
                            <span class="hamb-bottom"></span>
                        </button>
                    </div>
                    <!-- /#page-content-wrapper -->
                </div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
                <!-- Include all compiled plugins (below), or include individual files as needed -->
                <script src="js/bootstrap.min.js"></script>
                <script type="text/javascript" src="js/SidebarPractice.js"></script>
                <script>
                $("#menu-toggle").click(function(e) {
                    e.preventDefault();
                    $("#wrapper").toggleClass("toggled");
                });
                </script>
            </body>
            <?php            
        }
        elseif($_SESSION['Role'] == 'student')
        {
            ?>
            <body>
                <div id="wrapper">
                    <div class="overlay"></div>

                    <!-- Sidebar -->
                    <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
                        <ul class="nav sidebar-nav">
                            <li class="sidebar-brand">
                                <a href="/student/home/">Student Home</a>
                            </li>
                            <li class="dropdown">
                                <a href="/student/MyCourses/" class="dropdown-toggle" data-toggle="dropdown">My Courses<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li class="dropdown-header">Options</li>
                                    <li><a href="/student/MyCourses/ViewCourse/">   View Course</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="/student/MyTeachers/" class="dropdown-toggle" data-toggle="dropdown">My Teachers<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li class="dropdown-header">Options</li>
                                    <li><a href="/student/MyTeachers/ViewTeacherProfile/">   View Teacher Profile</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <!-- /#sidebar-wrapper -->

                    <!-- Page Content -->
                    <div id="page-content-wrapper">
                        <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                            <span class="hamb-top"></span>
                            <span class="hamb-middle"></span>
                            <span class="hamb-bottom"></span>
                        </button>
                    </div>
                </div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
                <!-- Include all compiled plugins (below), or include individual files as needed -->
                <script src="js/bootstrap.min.js"></script>
                <script type="text/javascript" src="js/SidebarPractice.js"></script>
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
        <!-- Reroute to log-in page if there is no session detected -->
        <meta http-equiv='refresh' content='0;index.php' />
        <?php
    }
    ?>    
</html>