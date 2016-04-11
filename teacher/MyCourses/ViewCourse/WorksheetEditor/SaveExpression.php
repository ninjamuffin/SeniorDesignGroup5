<?php

include '../../../../base.php';

if ((isset($_POST['Expression'])) && (isset($_POST['ContextVocab'])) && (isset($_POST['Pronunciation'])) && (isset($_POST['studentID'])) && (isset($_POST['AllDo'])) && (isset($_POST['expressionNum'])) && (isset($_POST['worksheetID'])) && (isset($_POST['courseID'])))
{
    
    
    $Expression = $_POST['Expression'];
    $ContextVocab = $_POST['ContextVocab'];
    $Pronunciation = $_POST['Pronunciation'];
    $StudentID = $_POST['studentID'];
    $AllDo = $_POST['AllDo'];
    $Number = $_POST['expressionNum'];
    $WorksheetID = $_POST['worksheetID'];
    $courseID = $_POST['courseID'];
    
    $params = array($StudentID, $Expression, $Pronunciation, $ContextVocab, $Number, $courseID, $AllDo, $WorksheetID);
    $options = array( "Scrollable" => 'static' );
    $writeexpressionSQL = "INSERT INTO Expressions(Date, StudentID, Expression, Pronunciation, [Context/Vocabulary], SentenceNumber, CourseID, AllDo, WorksheetID, IsDeleted) VALUES (GETDATE(), ?, ?, ?, ?, ?, ?, ?, ?, 0)";
    $writeexpression = sqlsrv_query($con, $writeexpressionSQL, $params, $options);
    if ($writeexpression === false)
        die(print_r(sqlsrv_errors(), true));
    
    /* Retrieve all expressions for the worksheet, and echo them to the calling page */
    $params = array($WorksheetID);
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
                          <input hidden type=\"text\" name=\"expressionid\" value=\"$ids[$i]\">
                          <input hidden type=\"text\" name=\"studentid\" value=\"$student_expression_ids[$i]\">
                          <input hidden type=\"text\" name=\"firstname\" value=\"$first_names[$i]\">
                          <input hidden type=\"text\" name=\"lastname\" value=\"$last_names[$i]\">

                          <button value=\"$ids[$i]\" type=\"button\" name=\"SelectExpression\" class=\"btn btn-primary\">Edit</button>
                      </form>
                  </td>
               </tr>";
    }

}
?>