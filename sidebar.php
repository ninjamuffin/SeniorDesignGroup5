<?php include "base.php"; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        
        <!-- Bootstrap -->
        <link href="/css/bootstrap.min.css.css" rel="stylesheet">
        <link href="/css/SidebarPractice.css" rel="stylesheet">
        <style>
            a{
                display:inline-block;
                padding:2px;
            }
        </style>
    </head>
    
    <?php
    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
    {
        if($_SESSION['Role'] == 'Admin')
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
                              <a class="dropdown-toggle" data-toggle="dropdown">Manage Website<span class="caret"></span></a>
                              <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="/Admin/ManageCorpus/">Corpus</a>
                                    <a href="/Admin/ManageCourses/">Courses</a>
                                    <a href="/Admin/ManageTeachers/">Teachers</a>
                                    <a href="/Admin/ManageStudents/">Students</a>
                                  </li>  
                              </ul>
                            </li>
                            
                            <li>
                                <a href="/corpus/">Corpus</a>
                            </li>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown">Archive<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="/Admin/Archive/Courses/" >Courses</a>
                                        <a href="/Admin/Archive/Students/">Students</a>
                                        <a href="/admin/Archive/Teachers/">Teachers</a>
                                    </li>
                              </ul>
                            </li>
                        </ul>
                    </nav>
                    <!-- /#sidebar-wrapper -->

                    <!-- Page Content -->
                    <!--<div id="page-content-wrapper">
                        <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                            <span class="hamb-top"></span>
                            <span class="hamb-middle"></span>
                            <span class="hamb-bottom"></span>
                        </button>
                    </div>-->
                    <!-- /#page-content-wrapper -->
                </div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
                <!-- Include all compiled plugins (below), or include individual files as needed -->
                <script src="js/bootstrap.min.js"></script>
                <script src="js/SidebarPractice.js"></script>
                <script>
                $("#menu-toggle").click(function(e) {
                    e.preventDefault();
                    $("#wrapper").toggleClass("toggled");
                });
                </script>
            </body>
        <?php
        }
        elseif($_SESSION['Role'] == 'Teacher')
        {
            $params = array($_SESSION['Username']);
            $options = array( "Scrollable" => 'static' );
            $getInstitutionsQuery = "
            SELECT I.InstitutionName, I.InstitutionID 
            FROM Institutions as I, TeachingInstance as TI
            WHERE TI.SiteUsername = ? AND
	              I.InstitutionID = TI.InstitutionID";
            $stmt = sqlsrv_query($con, $getInstitutionsQuery, $params, $options);
    
            if( $stmt === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            
            $institutions = [];
            $institution_ids = [];
            while( sqlsrv_fetch( $stmt ) === true) {
                $institutions[] = sqlsrv_get_field( $stmt, 0);
                $institution_ids[] = sqlsrv_get_field( $stmt, 1);
            }
            
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
                                  <?php
            $i = 0;
            foreach($institutions as $inst)
            {
                ?>
                                <li><a href="/teacher/MyCourses/?in=<?=$institution_ids[$i]?>"><?=$inst?></a></li>  
                                  <?php
                    $i += 1;
            }
                   ?>             
                              </ul>
                            </li>
                            <li>
                                <a href="/teacher/Archive/">Archive</a>
                                
                            </li>
                            <li>
                                <a href="/corpus/" class="dropdown-toggle" data-toggle="dropdown">Corpus<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">About</a>
                                        <a href="/Corpus/Search/">Search</a></li>
                                </ul>
                            </li>
                            
                        </ul>
                    </nav>
                    <!-- /#page-content-wrapper -->
                </div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
                <!-- Include all compiled plugins (below), or include individual files as needed -->
                <script src="js/bootstrap.min.js"></script>
                <script src="js/SidebarPractice.js"></script>
                <script>
                $("#menu-toggle").click(function(e) {
                    e.preventDefault();
                    $("#wrapper").toggleClass("toggled");
                });
                </script>
            </body>
            <?php            
        }
        elseif($_SESSION['Role'] == 'Student')
        {
            /* DB interaction: retrieve student's ID using SiteUsername; lookup all courses in [Enrollment]; print the active ones (with links) and provide a link to "...more" */
            
            
            
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
                                    <li><a href="/student/MyCourses/ViewCourse/">   View Course</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="/student/MyTeachers/" class="dropdown-toggle" data-toggle="dropdown">My Teachers<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="/student/MyTeachers/ViewTeacherProfile/">   View Teacher Profile</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <!-- /#sidebar-wrapper -->

                </div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
                <!-- Include all compiled plugins (below), or include individual files as needed -->
                <script src="js/bootstrap.min.js"></script>
                <script src="js/SidebarPractice.js"></script>
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