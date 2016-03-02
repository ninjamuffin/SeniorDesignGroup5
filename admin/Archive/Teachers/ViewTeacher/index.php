<?php 
include "../../../../base.php";
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
        $teacherID = isset($_GET['teacherID']) ? $_GET['teacherID'] : 0;
        if ($teacherID == 0)
            echo "<meta http-equiv='refresh' content=0;../";
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
                                <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                                    <span class="hamb-top"></span>
                                    <span class="hamb-middle"></span>
                                    <span class="hamb-bottom"></span>
                                </button>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Teacher Information</div>
                                    <div class="panel-body">
                                        <p>Show teacher history (new data will include number of classes, time frame of activity, list of institutions, etc.)</p>
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Teacher's Course Listing (sort by most recent)</div>
                                    <div class="panel-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <td>Course Number</td>
                                                    <td>Section</td>
                                                    <td>Year</td>
                                                    <td>Session</td>
                                                    <td>Course Page</td>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                                /* Set up and declare query entity */
                                                $params = array();
                                                $options = array( "Scrollable" => 'static' );
                                                $query = 
"SELECT  CN.[Course #], TC.[Section], Y.[Year], S.[Session], TC.[Teachers&ClassesID]
FROM [Teachers&Classes] as TC, [Advisor] as A, [Class Names] as CN, [Session] as S, [Sessions] as Ss, [Year] as Y
WHERE TC.[ClassNamesID] = CN.[ClassNamesID] AND 
      TC.[Instructor] = A.[ID] AND 
	  TC.[SessionID] = Ss.[SessionsID] AND
	  Y.[ID] = Ss.[Year_ID] AND
	  S.[ID] = Ss.[Session_ID] AND
      TC.[Teachers&ClassesID] in (SELECT DISTINCT OtherE.[Teachers&ClassesID] 
								  FROM Expressions as OtherE, [Teachers&Classes] as OtherTC 
								  WHERE OtherE.[Teachers&ClassesID] = OtherTC.[Teachers&ClassesID] AND
										OtherTC.[Instructor] = 94)
ORDER BY Y.[Year] desc";
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
                                                    $coursePageLink = "/Admin/Archive/Courses/ViewCourse/?courseID=$row[4]";
                                                    echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td><a href='$coursePageLink'>Course Page</a></td></tr>";
                                                }
                                                    
                                                echo "</tbody></table><br />";
                                                if($pageNum > 1)
                                                {
                                                    $prevPageLink = "?pageNum=".($pageNum - 1)."&teacherID=$teacherID";
                                                    echo "<a href='$prevPageLink'>Previous Page</a>&nbsp;&nbsp;";
                                                }
                                                $num = 1;
                                                $firstPageLink = "?pageNum=$num&teacherID=$teacherID";
                                                print("<a href=$firstPageLink>$num</a>&nbsp;&nbsp;");
                                                if($numOfPages < 20)
                                                {
                                                    for($i = 2; $i <=$numOfPages; $i++)
                                                    {
                                                        $pageLink = "?pageNum=$i&teacherID=$teacherID";
                                                        print("<a href=$pageLink>$i</a>&nbsp;&nbsp;");
                                                    }   
                                                }
                                                else
                                                {
                                                    for($i = 10; $i <$numOfPages; $i+= 10)
                                                    {
                                                        $pageLink = "?pageNum=$i&teacherID=$teacherID";
                                                        print("<a href=$pageLink>$i</a>&nbsp;&nbsp;");
                                                    }
                                                    $pageLink = "?pageNum=$numOfPages&teacherID=$teacherID";
                                                    print("<a href=$pageLink>$numOfPages</a>&nbsp;&nbsp;");
                                                }
                                                // Display Next Page link if applicable.
                                                if($pageNum < $numOfPages)
                                                {
                                                    $nextPageLink = "?pageNum=".($pageNum + 1)."&teacherID=$teacherID";
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
