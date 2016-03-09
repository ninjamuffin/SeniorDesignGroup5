<?php 
include "../../../../../base.php";
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
        $courseID = isset($_GET['courseID']) ? $_GET['courseID'] : 0;
        $worksheetNum = isset($_GET['worksheetNum']) ? $_GET['worksheetNum'] : 0;
        if ($courseID == 0 && $worksheetNum == 0)
            echo "<meta http-equiv='refresh' content='0;../../' />";
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
                            <div class="col-lg-5 col-md-5 col-sm-5">
                                <div class="panel panel-primary" >
                                    <div class="panel-heading">
                                        Course Details
                                    </div>
                                    <div class="panel-body">
                                        <?php
            $params = array($courseID);
            $options = array( "Scrollable" => 'static');
            $courseInfoQuery = "
              SELECT TC.CoursesID, CN.ClassName, TC.Section, T.FirstName, T.LastName, SN.SessionName, I.InstitutionName
            FROM TeachersCourses as TC, [Class Names] as CN, Teachers as T, Sessions as Ss, SessionNames as SN, Institutions as I
            WHERE TC.CoursesID = ? AND
                  CN.ClassNamesID = TC.ClassNamesID AND
                  T.TeacherID = TC.InstructorID AND
                  Ss.SessionsID = TC.SessionID AND
                  SN.SessionsID = Ss.SessionsID";
            $stmt = sqlsrv_query( $con, $courseInfoQuery, $params, $options);
            if ($stmt === false)
                die(print_r(sqlsrv_errors(), true));
            if (sqlsrv_fetch($stmt) === true)
            {
                $ClassName = sqlsrv_get_field($stmt, 1);
                $Section = sqlsrv_get_field($stmt, 2);
                $FirstName = sqlsrv_get_field($stmt, 3);
                $LastName = sqlsrv_get_field($stmt, 4);
                $Session = sqlsrv_get_field($stmt, 5);
                $Institution = sqlsrv_get_field($stmt, 6);
                
                
            }
            echo "<p>Class Name: $ClassName</p><p>Section: $Section</p><p>Teacher: $FirstName $LastName</p><p>Session: $Session</p><p>Hosting Institution: $Institution</p>";
            
            
            
            
                                        ?>
                                        
                                    </div>
                                </div>
                                
                                
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5">
                                <div class="panel panel-primary" style="min-height:220px">
                                    <div class="panel-heading">
                                        Worksheet Details
                                    </div>
                                    <div class="panel-body">
                                        <?php
            $params = array($courseID, $worksheetNum, $courseID, $worksheetNum);
            $options = array( "Scrollable" => 'static');
            $worksheetInfoQuery = "
              SELECT DISTINCT [TO].Topic, LEFT(CONVERT(VARCHAR, E.Date, 120), 10) 
		      FROM Expressions as E, Topics as [TO]
              WHERE E.[Teachers&ClassesID] = ? AND
                  E.[Worksheet#] = ? AND
				  [TO].Topic_ID = E.[Topic_ID] AND
                  E.Date = (SELECT min(Date) FROM Expressions WHERE [Teachers&ClassesID] = ? AND [Worksheet#] = ?)";
            $stmt = sqlsrv_query( $con, $worksheetInfoQuery, $params, $options);
            if ($stmt === false)
                die(print_r(sqlsrv_errors(), true));
            if (sqlsrv_fetch($stmt) === true)
            {
                $topic = sqlsrv_get_field($stmt, 0);
                $date = sqlsrv_get_field($stmt, 1);
            }
            echo "<p>Topic: $topic</p><p>Date: $date";
            ?>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Worksheet display</div>
                                    <!-- Select Rows Per Page -->
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Select rows per page
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                            <li><a href="?pp=10&courseID=<?=$courseID?>&worksheetNum=<?=$worksheetNum?>">10</a></li>
                                            <li><a href="?pp=20&courseID=<?=$courseID?>&worksheetNum=<?=$worksheetNum?>">20</a></li>
                                            <li><a href="?pp=30&courseID=<?=$courseID?>&worksheetNum=<?=$worksheetNum?>">30</a></li>
                                            <li><a href="?pp=50&courseID=<?=$courseID?>&worksheetNum=<?=$worksheetNum?>">50</a></li>
                                            
                                        </ul>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Student</th>
                                                    <th>Expression</th>
                                                    <th>Context/Vocab</th>
                                                    <th>Pronunciation</th>
                                                </tr>
                                            </thead>
                                            <tbody>
        <?php
            $params = array($courseID, $worksheetNum);
            $options = array( "Scrollable" => 'static' );
            $query = 
       "SELECT E.[Sentence number], S.[LastName], E.Expression, E.[Context/Vocabulary], E.[Pronunciation], E.Student_ID
        FROM Expressions as E, 
             Students as S, 
	         Country as C
        WHERE E.[Teachers&ClassesID] = ? AND
              E.[Worksheet#] = ? AND
		      S.ID = E.Student_ID AND
		      C.ID = S.Citizenship
        ORDER BY [Sentence number]";
            $stmt = sqlsrv_query($con, $query, $params, $options);
            if (!$stmt)
                die( print_r( sqlsrv_errors(), true));
            
            $rowsPerPage = isset($_GET['pp']) ? $_GET['pp'] : 10;
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
                $numOfPages = ceil($rowsReturned/$rowsPerPage);
            }
            
            $pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1;
            $page = Pagination::getPage($stmt, $pageNum, $rowsPerPage);
            foreach($page as $row)
            {
                $studentPageLink = "/Admin/Archive/Students/ViewStudent/?studentID=$row[5]";
                echo "<tr><td>$row[0]</td><td><a href='$studentPageLink'>$row[1]</a></td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td></tr>";
            }
            echo "</tbody></table>";
            $modulator = 3;
            Pagination::pageLinksArchiveWorksheet($numOfPages, $pageNum, $rowsPerPage, $rowsReturned, $modulator, $courseID, $worksheetNum);
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
