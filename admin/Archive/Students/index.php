<?php 
include "../../../base.php";
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
    <link href="/css/SidebarPractice.css" rel="stylesheet">
    <link href="/flatUI/css/theme.css" rel="stylesheet" media="screen">


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
                            <div class="col-lg-8 col-md-10">  
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Filter Results</div>
                                    <div class="panel-body">
                                        <form method="POST" id="filterTeachers" action="">
                                            <div class="form-group row">
                                                <div class="col-lg-10">
                                                    <input class="form-control" id="LastName" type="text" placeholder="Student Last Name" />
                                                    
                                                </div> 
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-10">
                                                    <input class="form-control" id="Language" type="text" placeholder="Language" />
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Apply Filter</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-10">
                                
                                <div class="panel panel-primary" >
                                    <div class="panel-heading">Student Archive</div>
                                    
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Select rows per page
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                            <li><a href="?pp=10">10</a></li>
                                            <li><a href="?pp=50">50</a></li>
                                            <li><a href="?pp=100">100</a></li>
                                            <li><a href="?pp=200">200</a></li>
                                            
                                            
                                        </ul>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-hover" style="max-height:600px;overflow-y: scroll;">
                                            <thead>
                                                <tr>
                                                    <td>First Name</td>
                                                    <td>Last Name</td>
                                                    <td>Language</td>
                                                    <!--<td>Joined Site</td>-->
                                                    <!--<td>Last active session</td>-->
                                                    <td>Go To</td>
                                                    <td>Courses Taken</td>
                                                </tr>
                                            </thead>
                                            <tbody>

<?php
    /* Set up and declare query entity */
    $params = array();
    $options = array( "Scrollable" => 'static' );
    $query = 
"SELECT S.[FirstName], S.[LastName], L.[Language], S.[ID], COUNT(DISTINCT E.[Teachers&ClassesID])
FROM Students as S, Expressions as E, Languages as L
WHERE L.[LanguageID] = S.[Language] AND
S.[ID] in (SELECT DISTINCT ES.Student_ID FROM Expressions as ES) AND
E.[Student_ID] = S.[ID]
GROUP BY S.[FirstName], S.[LastName], S.[ID], L.Language";
    $stmt = sqlsrv_query($con, $query, $params, $options);
    if ( !$stmt )
        die( print_r( sqlsrv_errors(), true));

    /* Extract Pagination Paramaters */
    $rowsPerPage = isset($_GET['pp']) ? $_GET['pp'] : 50; // get rows per page, default = 50
    $rowsReturned = sqlsrv_num_rows($stmt);
    if($rowsReturned === false)
        die(print_r( sqlsrv_errors(), true));
    elseif($rowsReturned == 0)
    {
        echo "No rows returned.";
        exit();
    }
    else
    {
        /* Calculate number of pages. */
        $numOfPages = ceil($rowsReturned/$rowsPerPage);
    }

    /* Echo results to the page */
    $pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1;
    $page = Pagination::getPage($stmt, $pageNum, $rowsPerPage);
    foreach($page as $row)
    {
        $studentPageLink = "ViewStudent/?studentID=$row[3]";
        echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td><a href='$studentPageLink'>Student's Page</a></td><td>$row[4]</td></tr>";
    }

    echo "</tbody></table><br />";
    $modulator = 4;
    Pagination::pageLinks($numOfPages, $pageNum, $rowsPerPage, $rowsReturned, $modulator);
    ?>
                                            
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
