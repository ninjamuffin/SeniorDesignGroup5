<?php
    include '../../../../base.php';

    if ((isset($_POST['Expressions'])) && (isset($_POST['ContextVocabs'])) && (isset($_POST['Pronunciations'])) && (isset($_POST['AllDos'])) && (isset($_POST['expressionNums'])) && (isset($_POST['worksheetID'])) && (isset($_POST['courseID'])) && (isset($_POST['reformulations'])) && (isset($_POST['expressionIDs'])) && (isset($_POST['isAltered'])) && (isset($_POST['EnrollmentIDs'])))
    {
        $expressions = $_POST['Expressions'];
        $contextvocabs = $_POST['ContextVocabs'];
        $pronunciations = $_POST['Pronunciations'];
        $alldos = $_POST['AllDos'];
        $expressionnums = $_POST['expressionNums'];
        $worksheetid = $_POST['worksheetID'];
        $courseid = $_POST['courseID'];
        $expressionIDs = $_POST['expressionIDs'];
        $reformulations = $_POST['reformulations'];
        $isAltered = $_POST['isAltered'];
        $enrollmentids = $_POST['EnrollmentIDs'];

        $params = array($worksheetid);
        $options = array("Scrollable" => 'static');

        $reformulationsSQL = "INSERT INTO Reformulations (ExpressionID, WorksheetID, ReformulationText) VALUES ";

        $expressionsSQL = "INSERT INTO Expressions (Date, EnrollmentID, Expression, Pronunciation, [Context/Vocabulary], SentenceNumber, CourseID, AllDo, WorksheetID, IsDeleted) VALUES ";

        $numExpressions = count($expressionIDs);
        for($i = 0; $i < $numExpressions; $i++)
        {
            if ($isAltered[$i] == 1)
            {
                if($expressionIDs[$i] == 0)
                { 
                    $expressionsSQL = $expressionsSQL . "(GETDATE(), '$enrollmentids[$i]', '$expressions[$i]', '$pronunciations[$i]', '$contextvocabs[$i]', '$expressionnums[$i]', '$courseid', '$alldos[$i]', '$worksheetid', 0), ";
                }
                else{
                    $updateexpressionSQL = "UPDATE Expressions SET Date = GETDATE(), EnrollmentID = $enrollmentids[$i], Expression = '$expressions[$i]', Pronunciation = '$pronunciations[$i]', [Context/Vocabulary] = '$contextvocabs[$i]', SentenceNumber = $expressionnums[$i], CourseID = $courseid, AllDo = $alldos[$i], WorksheetID = $worksheetid WHERE ExpressionID = $expressionIDs[$i]";

                    $updateexpression = sqlsrv_query($con, $updateexpression, $params, $options);
                    if($updateexpression === false)
                        die(print_r(sqlsrv_errors(), true));
                }
            }
        }
        $expressionsSQL = substr($expressionsSQL, 0, strlen($expressionsSQL) - 2);

        $expressions = sqlsrv_query($con, $expressionsSQL, $params, $options);
        if($expressions === false)
                        die(print_r(sqlsrv_errors(), true));

        $getallexpressionidsSQL = "SELECT E.ExpressionID
                                    FROM Expressions E
                                    WHERE E.WorksheetID = $worksheetID";
        $getallexpressionids = sqlsrv_query($con, $getallexpressionidsSQL, $params, $options);
        while(sqlsrv_fetch($getallexpressionids) === true)
        {
            $expressions[$i] = sqlsrv_get_field($expressions, 0);
        }

        for($i = 0; $i < $numExpressions; $i++)
        {
            if ($isAltered[$i] == 1)
            {
                if($expressionIDs[$i] == 0)
                { 
                    $reformulationsSQL = $reformulationsSQL . "($expressionIDs[$i], $worksheetID, '$reformulations[$i]'), ";
                }
                else{
                    $updatereformulationSQL = "UPDATE Reformulations SET ReformulationText = '$reformulations[$i]' WHERE ExpressionID = $expressionIDs[$i]";

                    $updatereformulation = sqlsrv_query($con, $updatereformulation, $params, $options);
                    if($updatereformulation === false)
                        die(print_r(sqlsrv_errors(), true));
                }
            }
        }
        $reformulationsSQL = substr($reformulationsSQL, 0, strlen($reformulationsSQL) - 2);

        $reformulations = sqlsrv_query($con, $reforumulationsSQL, $params, $options);
        if($reformulations === false)
                        die(print_r(sqlsrv_errors(), true));
        echo expressionsSQL;
        echo reformulationsSQL;
    }
    else
    {
        echo "Data Error";
    }
?>