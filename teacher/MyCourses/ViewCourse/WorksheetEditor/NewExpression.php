<?php

include '../../../../base.php';

if ((isset($_POST['worksheetID'])) && (isset($_POST['courseID'])))
{
    $sentence_number = isset($_POST['newexpressionnumber']) ? $_POST['newexpressionnumber'] : 0;
    $worksheetID = $_POST['worksheetID'];
    $courseID = $_POST['courseID'];
    $params = array($worksheetID);
    $options = array("Scrollable" => 'static');
    $coursestudentsSQL = "SELECT S.StudentID, S.FirstName, S.LastName
                          FROM Enrollment as ER, Worksheets as W, Courses C, Students S
                          WHERE W.WorksheetID = ? AND
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
    
    

echo "
<div class=\"panel-body\">
    <div class=\"control-group controls\" id=\"fields\">
        <form>
            <input hidden type=\"text\" name=\"newexpressionnumber\" value=\"$sentence_number\">
            <input hidden type=\"text\" name=\"worksheetID\" value=\"$worksheetID\">
            <input hidden type=\"text\" name=\"courseID\" value=\"$courseID\">
            <div class=\"form-group row\">
                
                <div class=\"col-xs-4 col-md-6\">
                    <h4 style=\"text-decoration:underline\">Sentence #$sentence_number</h4>
                    <label>Student:
                    <select class=\"form-control\" name=\"selectstudent\">
                        <option  selected=\"selected\" value=\"0\">--Select Student--</option>";
for($i = 0; $i < $num_students; $i++)
    echo "<option value=\"$studentids[$i]\">$first_names[$i] $last_names[$i]</option>";
echo "                       
                    </select></label>
                </div>
                <div class=\"col-xs-2\">
                    <div class=\"radio\">
                        <label><input type=\"radio\" value=\"all\" name=\"alldo\">All-Do</label>
                    </div>
                    <div class=\"radio\">
                        <label><input type=\"radio\" value=\"individual\" name=\"alldo\" checked=\"checked\">Individual</label>
                    </div>

                    
                </div>
            </div>
            <div class=\"form-group row\">
                <div class=\"col-md-8 col-xs-12\">
                    <label for=\"CorrectedExpr\">Expression:</label>
                        <input type=\"text\" class=\"form-control\" name=\"Expression\">
                </div>
            </div>
            <div class=\"form-group row\">
                <div class=\"col-md-5 col-xs-7\">
                    <label for=\"ContextVocab\">Context/Vocab: </label>
                    <input name=\"ContextVocab\"  type=\"text\" class=\"form-control\">
                </div>
                <div class=\"col-md-3 col-xs-5\">
                    <label for=\"PronCorr\">Pronunciation:</label>
                    <input type=\"text\"  class=\"form-control\" name=\"Pronunciation\">
                </div>
            </div>
            
            <div class=\"form-group row\">
                <div class=\"col-xs-12\">
                    <div class=\"btn-group\" role=\"group\">
                        <button type=\"button\" name=\"SaveExpression\"  class=\"btn btn-primary\">Save</button>
                    </div>
                    <div class=\"btn-group\" role=\"group\">
                        <button type=\"button\" id=\"SaveAndCreateNewExpression\"  class=\"btn btn-primary\">Save and Create a New Expression</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
";

    
}
?>