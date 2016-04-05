<!-- Course view (index.php) for Teacher account -->

<?php include "../../../base.php"; ?>
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
    <link href="/FlatUI/css/theme.css" rel="stylesheet">
    
    <!-- Including Header -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="/js/SidebarPractice.js"></script>
    <script>
        $(function(){
            $("#sidebar").load("/sidebar.php");
        });
    </script>

</head>
        
<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
    if($_SESSION['Role'] != 'Teacher')
    {
        ?>
        <p>You do not have permission to view this page.  Redirecting in 5 seconds</p>
        <p>Click <a href="/">here</a> if you don't want to wait</p>
        <meta http-equiv='refresh' content='5;/' />
        <?php
    }
    else
    {
        $courseID = isset($_POST['courseID']) ? $_POST['courseID'] : 0;
        if ($courseID == 0)
            echo "<meta http-equiv='refresh' content='0;../' />";
    
    ?>        

    <body>
        <div id="wrapper">
            <div id = "sidebar"></div>
            <div id="page-content-wrapper">
                <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                    <span class="hamb-top"></span>
                    <span class="hamb-middle"></span>
                    <span class="hamb-bottom"></span>
                </button>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3>Course Info</h3>
                                </div>
                                <div class="panel-body">
                                    <?php
                                        $courseinfoSQL = "SELECT CT.CourseName, I.InstitutionName, ST.SessionName, SI.Year, C.Section
                                        From Courses as C, SessionType as ST, SessionInstance as SI, Institutions as I, CourseTypes as CT
                                        WHERE C.CourseID = ?
                                        AND CT.CourseTypesID = C.CourseTypesID
                                        AND I.InstitutionID = C.InstitutionID
                                        AND SI.SessionInstanceID = C.SessionInstanceID
                                        AND ST.SessionTypeID = SI.SessionTypeID";
                                        $params = array($courseID);
                                        $options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
        
                                        $courseinfo = sqlsrv_query($con, $courseinfoSQL, $params, $options);
                                        if ( $courseinfo === false)
                                            die( print_r( sqlsrv_errors(), true));
                                        $length = sqlsrv_num_rows($courseinfo);

                                        if (sqlsrv_fetch( $courseinfo ) === true) 
                                        {
                                            $ClassName = sqlsrv_get_field( $courseinfo, 0);
                                            $InstitutionName = sqlsrv_get_field( $courseinfo, 1);
                                            $SessionName = sqlsrv_get_field( $courseinfo, 2);
                                            $SessionYear = sqlsrv_get_field( $courseinfo, 3);
                                            $Section = sqlsrv_get_field( $courseinfo, 4);
                                        }
                                    echo "<p>Name: $ClassName</p>
                                    <p>Institution: $InstitutionName</p>
                                    <p>Session: $SessionName $SessionYear</p>
                                    <p>Section: $Section</p>";
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3>Students</h3>
                                </div>
                                <div class="panel-body">
                                    <?php
        $params = array($courseID);
        $options = array( "Scrollable" => 'static' );
        $coursestudentsSQL = "SELECT S.FirstName, S.LastName, S.StudentID
                              FROM Students as S, Enrollment as ER, Courses as C
                              WHERE C.CourseID = ? AND
                                    ER.CourseID = C.CourseID AND
                                    S.StudentID = ER.StudentID";
        $coursestudents = sqlsrv_query($con, $coursestudentsSQL, $params, $options);
        if ($coursestudents === false)
            die(print_r(sqlsrv_errors(), true));
        $num_students = sqlsrv_num_rows($coursestudents);
        $firstnames = [];
        $lastnames = [];
        $ids = [];
        while (sqlsrv_fetch($coursestudents) === true)
        {
            $firstnames[] = sqlsrv_get_field($coursestudents, 0);
            $lastnames[] = sqlsrv_get_field($coursestudents, 1);
            $ids[] = sqlsrv_get_field($coursestudents, 2);
        }
        ?>
        
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Go To</th>
                                                <th>Go To Archive</th>
                                            </tr>
                                        </thead>
                                        <tbody>
        <?php
        for($i = 0; $i < $num_students; $i++)
        {
            echo "<tr>";
            echo "<td>$firstnames[$i] $lastnames[$i]</td>";
            echo "<td>
                    <form method=\"POST\" action=\"/Teacher/MyStudents/ViewStudent/\">
                      <input hidden type=\"text\" name=\"studentid\" value=\"$ids[$i]\">
                      <button class=\"btn btn-primary\">Student Page</button>
                    </form>
                  </td>";
            echo "<td>
                    <form method=\"POST\" action=\"/Teacher/Archive/Students/ViewStudent/\">
                      <input hidden type=\"text\" name=\"studentid\" value=\"$ids[$i]\">
                      <button class=\"btn btn-primary\">Archive Page</button>
                    </form>
                  </td>";
        }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-10 col-md-10">
                            <!-- Worksheet Listing -->
    <?php
        $WorksheetsSQL = "
        SELECT WorksheetID, WorksheetNumber, EditStatus, Date
        FROM Worksheets
        WHERE CourseID = ? ORDER BY WorksheetNumber";
        $params = array($courseID);
        $options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
        $worksheets = sqlsrv_query($con, $WorksheetsSQL, $params, $options);
        if ($worksheets === false)
            die(print_r(sqlsrv_errors(), true));
        $num_worksheets = sqlsrv_num_rows($worksheets);
        $new_worksheet_number = $num_worksheets + 1;
        
        $worksheetIDs = [];
        $worksheet_numbers = [];
        $statuses = [];
        $dates = [];
        while(sqlsrv_fetch($worksheets) === true)
        {
            $worksheetIDs[] = sqlsrv_get_field($worksheets, 0);
            $worksheet_numbers[] = sqlsrv_get_field($worksheets, 1);
            $statuses[] = sqlsrv_get_field($worksheets, 2);
            $dates[] = sqlsrv_get_field($worksheets, 3);
        }

    ?>
                            <div class="panel panel-primary">
                                <div class="panel-heading">Worksheets</div>
                                
                                <div class="panel-body">
                                    <form method="POST" action="WorksheetEditor/" name="NewWorksheet">
                                        <div class="form-group row">
                                            <div class="col-xs-4 col-sm-3">
                                                <input type="hidden" name="Number" value="<?=$new_worksheet_number?>">
                                                <button class="btn btn-primary" type="submit">New Worksheet</button>
                                            </div>
                                        </div>
                                    </form>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Go To</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
        echo $num_worksheets;
        for($i = 0; $i < $num_worksheets; $i++)
        {
            echo "<tr>";
            echo "<td>$worksheet_numbers[$i]</td>";
            echo "<td>$dates[$i]</td>";
            echo "<td>$statuses[$i]</td>";
            echo "<td><a href=\"#\">Do Something</a></td>";
            echo "<td>
                    <form method=\"POST\" name=\"publishworksheet\" action=\"PublishWorksheet.php\">
                      <input hidden type=\"text\" name=\"worksheetid\" value=\"$worksheetIDs[$i]\">
                      <button class=\"btn btn-primary\">Publish</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            
                            <!-- END PAGE CONTENT -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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