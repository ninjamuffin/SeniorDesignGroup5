<!-- Edit Worksheet (index.php) for Teacher account -->

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
    <script type="text/javascript" src="/js/dynamicRowTeacher.js"></script>
    
    
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
        $courseID = isset($_POST['courseID']) ? $_POST['courseID'] : 0;
        if (($worksheetID == 0) || ($courseID == 0))
            echo "<meta http-equiv='refresh' content='0;/' />";
        $worksheetDate = isset($_POST['worksheetDate']) ? $_POST['worksheetDate'] : 0;
        $worksheetTopic = isset($_POST['worksheetTopic']) ? $_POST['worksheetTopic'] : 0;
        $worksheetStatus = isset($_POST['worksheetStatus']) ? $_POST['worksheetStatus'] : 0;
        $worksheetNumber = isset($_POST['worksheetNumber']) ? $_POST['worksheetNumber'] : 0;
        $className = isset($_POST['className']) ? $_POST['className'] : 0;
        $params = array($worksheetID);
        $options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
        $worksheetexpressionsSQL = "SELECT E.SentenceNumber, S.StudentID, S.FirstName, S.LastName, E.Expression, E.ExpressionID, E.AllDo, E.Pronunciation, E.[Context/Vocabulary], ER.EnrollmentID, RF.ReformulationText
                                    FROM Expressions E, Students S, Enrollment ER, Reformulations RF
                                    WHERE E.WorksheetID = ? AND
                                          ER.StudentID = E.StudentID AND
                                          S.StudentID = ER.StudentID AND
                                          E.ExpressionID = RF.ExpressionID
                                    ORDER BY E.SentenceNumber";
        $worksheetexpressions = sqlsrv_query($con, $worksheetexpressionsSQL, $params, $options);
        if ($worksheetexpressions === false) {
            die(print_r(sqlsrv_errors(), true));
            $num_expressions = 0;
        }
        else {
            $num_expressions = sqlsrv_num_rows($worksheetexpressions);
        }
        $sent_numbers = [];
        $student_expression_ids = [];
        $first_names = [];
        $last_names = [];
        $expressions = [];
        $ids = [];
        $alldos = [];
        $pronunciation = [];
        $contextVocab = [];
        $enrollmentids = [];
        $reformulations = [];
        while(sqlsrv_fetch($worksheetexpressions) === true)
        {
            $sent_numbers[] = sqlsrv_get_field($worksheetexpressions, 0);
            $student_expression_ids[] = sqlsrv_get_field($worksheetexpressions, 1);
            $first_names[] = sqlsrv_get_field($worksheetexpressions,2);
            $last_names[] = sqlsrv_get_field($worksheetexpressions, 3);
            $expressions[] = sqlsrv_get_field($worksheetexpressions, 4);
            $ids[] = sqlsrv_get_field($worksheetexpressions, 5);
            $alldos[] = sqlsrv_get_field($worksheetexpressions, 6);
            $pronunciation[] = sqlsrv_get_field($worksheetexpressions, 7);
            $contextVocab[] = sqlsrv_get_field($worksheetexpressions, 8);
            $enrollmentids[] = sqlsrv_get_field($worksheetexpressions, 9);
            $reformulations[] = sqlsrv_get_field($worksheetexpressions, 10);
        }
        
        $coursestudentsSQL = "SELECT ER.EnrollmentID, S.FirstName, S.LastName
                              FROM Enrollment as ER, Worksheets as W, Courses C, Students S
                              WHERE W.WorksheetID = ? AND
                                    C.CourseID = W.CourseID AND
                                    ER.CourseID = C.CourseID AND
                                    S.StudentID = ER.StudentID";
        $coursestudents = sqlsrv_query($con, $coursestudentsSQL, $params, $options);
        if ($coursestudents === false)
            die(print_r(sqlsrv_errors(), true));
        $num_students = sqlsrv_num_rows($coursestudents);
        $listenrollmentids = [];
        $listfirstnames = [];
        $listlastnames = [];
        
        while(sqlsrv_fetch($coursestudents) === true)
        {
            $listenrollmentids[] = sqlsrv_get_field($coursestudents, 0);
            $listfirstnames[] = sqlsrv_get_field($coursestudents, 1);
            $listlastnames[] = sqlsrv_get_field($coursestudents, 2);
        }
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
                            <h1 class="pull-right"><button type="button" class="btn btn-lg btn-primary pull-right" id="SaveWorksheet">Save Worksheet</button></h1>
                        </div>
                        <hr>
                        <div class="row col-xs-12">
                            <div class="col-xs-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Worksheet Info</div>
                                    <div class="panel-body">
                                        <div class="col-xs-12">
                                            <?php
                                                echo "
                                                    <h3>Course: $className</h3>
                                                    <h5>Worksheet Number: $worksheetNumber</h5>
                                                    <h5>Date: $worksheetDate</h5>
                                                    <h5>Topic: $worksheetTopic</h5>";
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <div class="panel panel-primary" style="max-height:300px;overflow-y:scroll">
                                <div class="panel-heading">Worksheet Overview</div>
                                    <div class="panel-body">
                                        <div style="display: none" id="numExprs"><?php echo "$num_expressions";?></div>
                                        <div class="col-xs-12">
                                            <form method="POST" name="newexpression">
                                                <button type="button" id="NewExpression" name="NewExpression" class="btn btn-primary">
                                                    New Expression
                                                </button>
                                            </form>
                                        </div>
                                        <div style="display:none" id="WorksheetID"><?php echo "$worksheetID";?></div>
                                        <div style="display:none" id="CourseID"><?php echo "$courseID";?></div>
                                        <table class="table" id="myTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Student</th>
                                                    <th>Expression</th>
                                                    <th>Correction</th>
                                                    <th>All-Do</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody name="ExpressionTable">
<?php 
        for($i = 0; $i < $num_expressions; $i++)
        {
            $pass_array = array($ids[$i], $student_expression_ids[$i], $first_names[$i], $last_names[$i]);
            echo "<tr id=\"$i\">
                      <td class=\"nr\">$sent_numbers[$i]</td>
                      <td class=\"name\">$first_names[$i] $last_names[$i]</td>
                      <td class=\"expr\">$expressions[$i]</td>
                      <td class=\"reform\">$reformulations[$i]</td>
                      <td style=\"display: none\" class=\"context\">$contextVocab[$i]</td>
                      <td style=\"display: none\" class=\"pronCorr\">$pronunciation[$i]</td>
                      <td style=\"display: none\" class=\"enrollmentid\">$enrollmentids[$i]</td>
                      <td id=\"alldoSymbol\">";
            if ($alldos[$i] == 1)
                echo "<span class=\"glyphicon glyphicon-ok\"></span>";
            else
                echo "<span class=\"glyphicon glyphicon-remove\"></span>";
            echo "
                      </td>
                      <td style=\"display: none\" class=\"allDo\">$alldos[$i]</td>
                      <td style=\"display: none\" class=\"isAltered\">0</td>
                      <td style=\"display: none\" class=\"expressionID\">$ids[$i]</td>
                      <td>
                        <button value=\"$i\" type=\"button\" name=\"Edit\" class=\"btn btn-primary\">Edit</button>
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
                        <div class="col-xs-12">
                            <div class="panel panel-primary" style="min-height:450px;">
                                <div class="panel-heading"><h4>Expression Editor</h4></div>
                                <div name="ExpressionEditor">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <h4 style="text-decoration:underline" id="SentenceNum">
                                                    <span id="exprStatus">Select or Create New Expression</span>
                                                    <span id="exprNum"></span>
                                                </h4>
                                                <label>Student:
                                                <select class="form-control" id="selectstudent">
                                                    <option name="defaultSelect" selected value="0">--Select Student--</option>";
<?php
    for($i = 0; $i < $num_students; $i++)
        echo "<option name=\"studentSelect\" value=\"$listenrollmentids[$i]\">$listfirstnames[$i] $listlastnames[$i]</option>";
?>                      
                                                </select></label>
                                            </div>

                                            <div class="btn-group col-xs-2" data-toggle="buttons">
                                                <label class="btn btn-primary">
                                                    <input type="radio" value="1" name="alldo" id="alldue"/>All-Do
                                                </label>
                                                <label class="btn btn-primary active">
                                                    <input type="radio" value="0" name="alldo" id="indy" checked="checked"/>Individual
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-5">
                                                <label for="ExprToEdit">Student Expression:</label>
                                                <input name="ExprToEdit" type="text" class="form-control" placeholder="SELECT AN EXPRESSION TO EDIT FROM ABOVE"/>
                                            </div>
                                            <div class="col-xs-5">
                                                <label for="Corr">Correction:</label>
                                                <input name="Corr" type="text" class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-5 form-group">
                                                <label for="ContextVocab">Context/Vocab: </label>
                                                <input name="context"  type="text" class="form-control" id="context"/>
                                            </div>
                                            <div class="col-xs-5 form-group">
                                                <label for="PronCorr">Pronunciation:</label>
                                                <input type="text"  class="form-control" name="pronCorr" id="pronunciation"/>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="button" id="Save" class="btn btn-lg btn-primary">Save</button>
                                        </div>
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