<?php 
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
                                    <div class="panel-heading">Student Information</div>
                                    <div class="panel-body">
                                        <p>Provides search interface for looking up courses in the DB. Would then display list of worksheets in the class, or, alternatively (tabs) all worksheets/expressions submitted by the teacher</p>
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Course Listing (sort by most recent)</div>
                                    <div class="panel-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <td>First Name</td>
                                                    <td>Last Name</td>
                                                    <td>Citizenship</td>
                                                    <!--<td>Language</td>-->
                                                    <!--<td>Joined Site</td>-->
                                                    <!--<td>Last active session</td>-->
                                                    <td>Link to Student's Page</td>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                                /* Set up and declare query entity */
                                                $params = array();
                                                $options = array( "Scrollable" => 'static' );
                                                $query = 
"SELECT S.[First Name], S.[Last Name], C.[Country], S.[ID]
 FROM Students as S, Country as C
 WHERE C.[ID] = S.[Citizenship] AND
       S.[ID] in (SELECT DISTINCT Student_ID FROM Expressions)";
                                                $stmt = sqlsrv_query($con, $query, $params, $options);
                                                if ( !$stmt )
                                                    die( print_r( sqlsrv_errors(), true));
                                                
                                                /* Extract Pagination Paramaters */
                                                $rowsPerPage = 10;
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
                                                $page = getPage($stmt, $pageNum, $rowsPerPage);
                                                foreach($page as $row)
                                                {
                                                    $studentPageLink = "ViewStudent/?studentID=$row[3]";
                                                    echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td><a href='$studentPageLink'>Student's Page</a></td></tr>";
                                                }
                                                    
                                                echo "</tbody></table><br />";
                                                if($pageNum > 1)
                                                {
                                                    $prevPageLink = "?pageNum=".($pageNum - 1);
                                                    echo "<a href='$prevPageLink'>Previous Page</a>&nbsp;&nbsp;";
                                                }
                                                $num = 1;
                                                $firstPageLink = "?pageNum=$num";
                                                print("<a href=$firstPageLink>$num</a>&nbsp;&nbsp;");
                                                if($numOfPages < 20)
                                                {
                                                    for($i = 2; $i <=$numOfPages; $i++)
                                                    {
                                                        $pageLink = "?pageNum=$i";
                                                        print("<a href=$pageLink>$i</a>&nbsp;&nbsp;");
                                                    }   
                                                }
                                                elseif($numOfPages < 180)
                                                {
                                                    for($i = 10; $i <$numOfPages; $i+= 10)
                                                    {
                                                        $pageLink = "?pageNum=$i";
                                                        print("<a href=$pageLink>$i</a>&nbsp;&nbsp;");
                                                    }
                                                    $pageLink = "?pageNum=$numOfPages";
                                                    print("<a href=$pageLink>$numOfPages</a>&nbsp;&nbsp;");
                                                }
                                                else
                                                {
                                                    for($i = 30; $i <$numOfPages; $i+= 30)
                                                    {
                                                        $pageLink = "?pageNum=$i";
                                                        print("<a href=$pageLink>$i</a>&nbsp;&nbsp;");
                                                    }
                                                    $pageLink = "?pageNum=$numOfPages";
                                                    print("<a href=$pageLink>$numOfPages</a>&nbsp;&nbsp;");
                                                }
                                                // Display Next Page link if applicable.
                                                if($pageNum < $numOfPages)
                                                {
                                                    $nextPageLink = "?pageNum=".($pageNum + 1);
                                                    echo "&nbsp;&nbsp;<a href='$nextPageLink'>Next Page</a>";
                                                }
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
