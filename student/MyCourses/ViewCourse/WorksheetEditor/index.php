<!-- Edit Worksheet (index.php) for Student account -->

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
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/simple-sidebar.css" rel="stylesheet">
    <link href="/css/SidebarPractice.css" rel="stylesheet">
    <link href="/flatUI/css/theme.css" rel="stylesheet" media="screen">
    
    <!-- Including Header -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="/js/SidebarPractice.js"></script>
    <script type="text/javascript" src="/js/dynamicRowStudent.js"></script>
    <style>
        .glyphicon:before {
            visibility: visible;
        }
        .glyphicon.glyphicon-star-empty:checked:before {
            content: "\e006";
        }
        input[type=checkbox].glyphicon{
            visibility: hidden;

        }
        .mycontent-left {
            border-right: 1px solid #333;
        }
    </style>
    
    <script>
        $(function(){
            $("#sidebar").load("/sidebar.php");
        });
    </script>
    
    <!-- Background Setup -->
    <style>
        .dropdown-backdrop {
            position: static;
        } 
    </style>
</head>
        
<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
    if($_SESSION['Role'] != 'Student')
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
        $courseID = isset($_POST['courseID']) ? $_POST['courseID'] : 0;
        if (($worksheetID == 0) || ($courseID == 0))
            echo "<meta http-equiv='refresh' content='0;/' />";
        
        $params = array($worksheetID);
        $options = array( "Scrollable" => 'static' );
        $worksheetinfoSQL = "SELECT W.WorksheetNumber, CONVERT(VARCHAR(11), W.Date, 106), T.Topic
                             FROM Worksheets W, Topics T
                             WHERE W.WorksheetID = ? AND
                                   T.TopicID = W.TopicID";
        $worksheetinfo = sqlsrv_query($con, $worksheetinfoSQL, $params, $options);
        if ($worksheetinfo === false)
            die(print_r(sqlsrv_errors(), true));
        if (sqlsrv_fetch($worksheetinfo) === true)
        {
            $worksheet_number = sqlsrv_get_field($worksheetinfo, 0);
            $date = sqlsrv_get_field($worksheetinfo, 1);
            $topic = sqlsrv_get_field($worksheetinfo, 2);
        }
        
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
        
        $coursestudentsSQL = "SELECT ER.StudentID 
                              FROM Enrollment as ER, Worksheets as W, Courses C 
                              WHERE W.WorksheetID = ? AND
                                    C.CourseID = W.CourseID AND
                                    ER.CourseID = C.CourseID";
        $coursestudents = sqlsrv_query($con, $coursestudentsSQL, $params, $options);
        if ($coursestudents === false)
            die(print_r(sqlsrv_errors(), true));
        $num_students = sqlsrv_num_rows($coursestudents);
        $studentsids = [];
        while(sqlsrv_fetch($coursestudents) === true)
            $studentids[] = sqlsrv_get_field($coursestudents, 0);
    ?>
    
<body>
    <section class="container-fluid col-xs-12">                     
        <!--body-->
        <div id="wrapper">
            <div id="sidebar"></div>
            <div id="page-content-wrapper">
                <div class="container-fluid">
                    <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                        <span class="hamb-top"></span>
                        <span class="hamb-middle"></span>
                        <span class="hamb-bottom"></span>
                    </button>
                    <!-- BEGIN PAGE CONTENT -->
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Worksheet Info</div>
                                    <div class="panel-body">
                                        <h5>Worksheet Number: <?=$worksheet_number?></h5>
                                        <h5>Date: <?=$date?></h5>
                                        <h5>Topic: <?=$topic?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <div class="panel panel-primary" style="max-height:350px;overflow-y:scroll">
                                <div class="panel-heading">Worksheet Overview</div>
                                    <div class="panel-body">
                                        <table class="table" id="myTable" >
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Student</th>
                                                    <th>Expression</th>
                                                    <th>All-Do</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody name="ExpressionTable">
<?php 
        for($i = 0; $i < $num_expressions; $i++)
        {
            $pass_array = array($ids[$i], $student_expression_ids[$i], $first_names[$i], $last_names[$i]);
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
                </td>
                      <td><form method=\"POST\" name=\"expressions{$i}\">
                              <input hidden type=\"text\" name=\"expressionID\" value=\"$ids[$i]\">
                              <input hidden type=\"text\" name=\"studentID\" value=\"$student_expression_ids[$i]\">
                              <input hidden type=\"text\" name=\"firstname\" value=\"$first_names[$i]\">
                              <input hidden type=\"text\" name=\"lastname\" value=\"$last_names[$i]\">
                              <input hidden type=\"text\" name=\"courseID\" value=\"$courseID\">
                              <input hidden type=\"text\" name=\"worksheetID\" value=\"$worksheetID\">
                              <input hidden type=\"text\" name=\"newexpressionnumber\" value=\"$new_expression_number\">
                              <button value=\"$ids[$i]\" type=\"button\" name=\"SelectExpression\" class=\"btn btn-primary\">Edit</button>
                          </form>
                      </td>
                   </tr>";
        }
?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" style="top-margin:40px;">
                            <div class="panel-heading" id="ExprHeading">Expression Edit Window
                                <span id="ExprID" class=""></span>
                            </div>


                            <div class="panel-body">
                                <div class="col-xs-8" name="left column">
                                    <div class="col-xs-11" style="text-align: left";>
                                        Expression
                                    </div>

                                    <div class="col-xs-12">
                                        <textarea disabled id="ExprToEdit" class="form-control" class="col-xs-11">
                                        </textarea>
                                    </div>

                                    <div class="col-xs-12" style="padding-top: 40px">
                                        <form role="form">
                                            <div class="form-group">
                                                <label for="CorrectedExpr">Correction:</label>
                                                <input type="text" class="form-control" id="CorrectedExpr" placeholder="Enter the correct expression here" />
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-xs-4" name="right column">
                                    <div class="col-xs-12">

                                    </div>
                                    <div class="col-xs-12">
                                        <button id="SubmitExpr"  class="btn btn-primary pull-right">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PAGE CONTENT -->
                </div>
            </div>
        </div>
    </section>
        
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
    $('.dropdown-toggle').click(function(e) {
        e.preventDefault();
        setTimeout($.proxy(function() {
            if ('ontouchstart' in document.documentElement) {
                $(this).siblings('.dropdown-backdrop').off().remove();
            }
        }, this), 0);
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