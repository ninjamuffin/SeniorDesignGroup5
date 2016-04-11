<?php 
require_once ('../../../../base.php');
//test connection speed.. require vs include

if ((isset($_POST['expressionID'])) && (isset($_POST['courseID'])) && (isset($_POST['worksheetID'])))
{
    
    $courseID = $_POST['courseID'];
    $worksheetID = $_POST['worksheetID'];
    $expressionID = $_POST['expressionID'];
    $params = array($expressionID);

    $options = array("Scrollable" => 'static');
    $coursestudentsSQL = "SELECT S.StudentID, S.FirstName, S.LastName
                          FROM Expressions as E, Enrollment as ER, Worksheets as W, Courses C, Students S
                          WHERE E.ExpressionID = ? AND
                                W.WorksheetID = E.WorksheetID AND
                                C.CourseID = W.CourseID AND
                                ER.CourseID = C.CourseID AND
                                S.StudentID = ER.StudentID";
    $coursestudents = sqlsrv_query($con, $coursestudentsSQL, $params, $options);
    if ($coursestudents === false)
        die(print_r(sqlsrv_errors(), true));
    $num_students = sqlsrv_num_rows($coursestudents);
    $studentsids = [];
    $first_names = [];
    $last_names = [];
    while(sqlsrv_fetch($coursestudents) === true)
    {
        $studentids[] = sqlsrv_get_field($coursestudents, 0);
        $first_names[] = sqlsrv_get_field($coursestudents, 1);
        $last_names[] = sqlsrv_get_field($coursestudents, 2);
    }
    
    $expressiondataSQL = "SELECT E.Expression, E.[Context/Vocabulary], E.Pronunciation, S.StudentID, S.FirstName, S.LastName, E.AllDo, E.[SentenceNumber]
                          FROM Expressions E, Students S
                          WHERE E.ExpressionID = ? AND
                                S.StudentID = E.StudentID";
    $expressiondata = sqlsrv_query($con, $expressiondataSQL, $params, $options);
    if ($expressiondata === false)
        die(print_r(sqlsrv_errors(), true));
    if (sqlsrv_fetch($expressiondata) === true)
    {
        $expression = sqlsrv_get_field($expressiondata, 0);
        $context = sqlsrv_get_field($expressiondata, 1);
        $pronunciation = sqlsrv_get_field($expressiondata, 2);
        $selected_student_id = sqlsrv_get_field($expressiondata, 3);
        $selected_first_name = sqlsrv_get_field($expressiondata, 4);
        $selected_last_name = sqlsrv_get_field($expressiondata, 5);
        $alldo = sqlsrv_get_field($expressiondata, 6);
        $sentence_number = sqlsrv_get_field($expressiondata, 7);
    }  

    

echo "
<div class=\"panel-body\">
    <div class=\"control-group controls\" id=\"fields\">
        <form>
            <input hidden type=\"text\" name=\"courseID\" value=\"$courseID\">
            <input hidden type=\"text\" name=\"worksheetID\" value=\"$worksheetID\">
            <input hidden type=\"text\" name=\"newexpressionnumber\" value=\"$sentence_number\">
            <input hidden type=\"text\" name=\"expressionID\" value=\"$expressionID\">
            
            <div class=\"form-group row\">
                
                <div class=\"col-xs-4 col-md-6\">
                    <h4 style=\"text-decoration:underline\">Sentence #$sentence_number</h4>
                    <label>Student:
                    <select class=\"form-control\" name=\"selectstudent\">
                        <option  selected=\"selected\" value=\"$selected_student_id\">$selected_first_name $selected_last_name</option>";
for($i = 0; $i < $num_students; $i++)
{
    if ($studentids[$i] != $selected_student_id)
        echo "<option value=\"$studentids[$i]\">$first_names[$i] $last_names[$i]</option>";
}
echo "                       
                    </select></label>
                </div>
                <div class=\"col-xs-2\">";
if ($alldo == 1)
{
    echo "<div class=\"radio\">
                        <label><input type=\"radio\" name=\"alldo\" checked=\"checked\">All-Do</label>
                    </div>
                    <div class=\"radio\">
                        <label><input type=\"radio\" name=\"alldo\" >Individual</label>
                    </div>";
}
else
{
    echo "<div class=\"radio\">
                        <label><input type=\"radio\" name=\"alldo\">All-Do</label>
                    </div>
                    <div class=\"radio\">
                        <label><input type=\"radio\" name=\"alldo\" checked=\"checked\">Individual</label>
                    </div>";
}
echo "
                    
                </div>
            </div>
            <div class=\"form-group row\">
                <div class=\"col-md-8 col-xs-12\">
                    <label for=\"CorrectedExpr\">Expression:</label>
                        <input type=\"text\" value=\"$expression\" class=\"form-control\" id=\"CorrectedExpr\" name=\"Expression\">
                </div>
            </div>
            <div class=\"form-group row\">
                <div class=\"col-md-5 col-xs-7\">
                    <label for=\"ContextVocab\">Context/Vocab: </label>
                    <input id=\"ContextVocab\" name=\"ContextVocab\" value=\"$context\" type=\"text\" class=\"form-control\">
                </div>
                <div class=\"col-md-3 col-xs-5\">
                    <label for=\"PronCorr\">Pronunciation:</label>
                    <input type=\"text\" value=\"$pronunciation\" class=\"form-control\" id=\"PronCorr\" name=\"Pronunciation\">
                </div>
            </div>
            
            <div class=\"form-group row\">
                <div class=\"col-xs-12\">
                    <div class=\"btn-group\" role=\"group\">
                        <button type=\"button\" id=\"Save\"  name=\"SaveExpression\" class=\"btn btn-primary\">Save</button>
                    </div>
                    <div class=\"btn-group\" role=\"group\">
                        <button type=\"button\" id=\"SaveAndCreateNew\" name=\"SaveAndCreateNew\" class=\"btn btn-primary\">Save and Create a New Expression</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
";
}
?>