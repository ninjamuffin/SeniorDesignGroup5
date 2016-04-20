<!-- View Worksheet (index.php) for Teacher account -->

<?php include "../../../../base.php"; ?>
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
    <link rel="stylesheet/less" type="text/css" href="/datepicker.less" />
    <link href="/css/SidebarPractice.css" rel="stylesheet">
    <link href="/FlatUI/css/theme.css" rel="stylesheet" media="screen">
    
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
        $worksheetID = isset($_POST['worksheetID']) ? $_POST['worksheetID'] : 0;
        if ($worksheetID == 0)
            echo "<meta http-equiv='refresh' content='40;/' />";
        $worksheetDate = isset($_POST['worksheetDate']) ? $_POST['worksheetDate'] : 0;
        $worksheetTopic = isset($_POST['worksheetTopic']) ? $_POST['worksheetTopic'] : 0;
        $worksheetStatus = isset($_POST['worksheetStatus']) ? $_POST['worksheetStatus'] : 0;
        $worksheetNumber = isset($_POST['worksheetNumber']) ? $_POST['worksheetNumber'] : 0;
        $className = isset($_POST['className']) ? $_POST['className'] : 0;
        $params = array($worksheetID);
        $options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
        $worksheetexpressionsSQL = "SELECT E.SentenceNumber, S.StudentID, S.FirstName, S.LastName, E.Expression, E.ExpressionID, E.AllDo
                                    FROM Expressions E, Students S, Enrollment ER
                                    WHERE E.WorksheetID = ? AND
                                          ER.StudentID = E.StudentID AND
                                          S.StudentID = ER.StudentID 
                                    ORDER BY E.SentenceNumber";
        $worksheetexpressions = sqlsrv_query($con, $worksheetexpressionsSQL, $params, $options);
        if ($worksheetexpressions === false)
            die(print_r(sqlsrv_errors(), true));
        $num_expressions = sqlsrv_num_rows($worksheetexpressions);
        $new_expression_number = $num_expressions + 1;
        $sent_numbers = [];
        $student_expression_ids = [];
        $first_names = [];
        $last_names = [];
        $expressions = [];
        $ids = [];
        $alldos = [];
        while(sqlsrv_fetch($worksheetexpressions) === true)
        {
            $sent_numbers[] = sqlsrv_get_field($worksheetexpressions, 0);
            $student_expression_ids[] = sqlsrv_get_field($worksheetexpressions, 1);
            $first_names[] = sqlsrv_get_field($worksheetexpressions,2);
            $last_names[] = sqlsrv_get_field($worksheetexpressions, 3);
            $expressions[] = sqlsrv_get_field($worksheetexpressions, 4);
            $ids[] = sqlsrv_get_field($worksheetexpressions, 5);
            $alldos[] = sqlsrv_get_field($worksheetexpressions, 6);
        }
        
        $worksheetsubmissionsSQL = "SELECT S.FirstName, S.LastName, SS.StudentSubmissionID, CONVERT(VARCHAR(11), SS.Date,106), SS.AttemptNumber
        FROM Students S, Enrollment ER, StudentSubmissions SS
        WHERE SS.WorksheetID = ? AND
              ER.EnrollmentID = SS.EnrollmentID AND
              S.StudentID = ER.StudentID";
        $worksheetsubmissions = sqlsrv_query($con, $worksheetsubmissionsSQL, $params, $options);
        if($worksheetsubmissions === false)
            die(print_r(sqlsrv_errors(),true));
        $num_submissions = sqlsrv_num_rows($worksheetsubmissions);
        $sub_first_names = [];
        $sub_last_names = [];
        $sub_ids = [];
        $sub_dates = [];
        $sub_attempts = [];
        while(sqlsrv_fetch($worksheetsubmissions) === true)
        {
            $sub_first_names[] = sqlsrv_get_field($worksheetsubmissions, 0);
            $sub_last_names[] = sqlsrv_get_field($worksheetsubmissions, 1);
            $sub_ids[] = sqlsrv_get_field($worksheetsubmissions, 2);
            $sub_dates[] = sqlsrv_get_field($worksheetsubmissions, 3);
            $sub_attempts[] = sqlsrv_get_field($worksheetsubmissions, 4);
        }
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
                        <div class="col-xs-6">
                            <h1>Edit Worksheet<form method="POST" name="AnnotationEditorOpen" id="AnnotationEditorOpen">
                                <input hidden type="text" id="worksheetID" name="worksheetID">
                                <button class="btn btn-lg btn-primary" type="submit">Annotate</button>
                            </form></h1>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <!-- Worksheet Info -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">Worksheet Info</div>
                                <div class="panel-body">
                                    <?php
                                    echo "
                                    <h2>Course: $className</h2>
                                    <h5>Worksheet Number: $worksheetNumber</h5>
                                    <h5>Date: $worksheetDate</h5>
                                    <h5>Topic: $worksheetTopic</h5>";?>
                                </div> 
                            </div>
                        </div>
                        <div class="col-sm-8">
                            
                            <!-- Worksheet contents -->
                            <div class="panel panel-primary" style="min-height:400pxs;max-height-400px; overflow-y:scroll">
                                <div class="panel-heading">Worksheet Expressions</div>
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Student</th>
                                                <th>Expression</th>
                                                <th>All-Do</th>
                                            </tr>
                                        </thead>
                                        <tbody name="ExpressionTable">
<?php
        for($i = 0; $i < $num_expressions; $i++)
        {
            echo "<tr>
                        <td>$sent_numbers[$i]</td>
                        <td>$first_names[$i] $last_names[$i]</td>
                        <td>$expressions[$i]</td>
                        <td>";
            if ($alldos[$i] == 1)
                echo "<span class=\"glyphicon glyphicon-ok\"></span>";
            else
                echo "<span class=\"glyphicon glyphicon-remove\"></span>";
            echo "
                </td></tr>";
        }
?>
                                        </tbody>
                                    </table>
                                    
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- Student submissions -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">Submissions</div>
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Student</th>
                                                <th>Attempt #</th>
                                                <th>Date</th>
                                                <th>Go To</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
        for($i = 0; $i < $num_submissions; $i++)
        {
            echo "<tr>
                        <td>$sub_first_names[$i] $sub_last_names[$i] </td>
                        <td>$sub_attempts[$i] </td>
                        <td>$sub_dates[$i] </td>
                        <td><form method=\"POST\" action=\"ViewSubmission/\" name=\"ViewSubmission\"><input hidden type=\"text\" name=\"submissionID\" value=\"$sub_ids[$i]\"><button class=\"btn btn-primary\">View Submission</button></form></td>";
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