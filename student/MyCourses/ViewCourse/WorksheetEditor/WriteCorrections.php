<?php
include '../../../../base.php';

if (isset($_POST['worksheetID']) && isset($_POST['expressionIDs']) && isset($_POST['correctedText']) && isset($_POST['enrollmentID']) )
{
    $worksheetID = $_POST['worksheetID'];
    $expressionIDs = $_POST['expressionIDs'];
    $correctedText = $_POST['correctedText'];
    $enrollmentID = $_POST['enrollmentID'];
    $params = array($enrollmentID, $worksheetID);
    $options = array("Scrollable" => 'static');

    $studentsubmissionsSQL = "INSERT INTO StudentSubmissions VALUES (?, ?, 1, 0, GETDATE())";
    $studentsubmissions = sqlsrv_query($con, $studentsubmissionsSQL, $params, $options);
    if ($studentsubmissions === false)
        die(print_r(sqlsrv_errors(), true));

    $getstudentsubmissionidSQL = "SELECT DISTINCT StudentSubmissionID FROM StudentSubmissions
                            WHERE EnrollmentID = ? AND
                                  WorksheetID = ? AND
                                  AttemptNumber = 1";
    $getstudentsubmissionid = sqlsrv_query($con, $getstudentsubmissionidSQL, $params, $options);
    if ($getstudentsubmissionid === false)
        die(print_r(sqlsrv_errors(), true));
    while(sqlsrv_fetch($getstudentsubmissionid) === true)
        $studentsubmissionid = sqlsrv_get_field($getstudentsubmissionid, 0);

    $studentattemptsSQL = "INSERT INTO StudentAttempts (ExpressionID, StudentSubmissionID, ReformulationText) VALUES ";
    $numExpressions = count($expressionIDs);
    //echo "$numExpressions";
    //echo "($expressionIDs[0], $studentsubmissionid, $correctedText[0])";
    for($i = 0; $i < $numExpressions; $i++)
    {
        if ($i == $numExpressions - 1)
        {
                $studentattemptsSQL = $studentattemptsSQL . "($expressionIDs[$i], $studentsubmissionid, '$correctedText[$i]')";
        }
        else
        {
                $studentattemptsSQL = $studentattemptsSQL . "($expressionIDs[$i], $studentsubmissionid, '$correctedText[$i]'), ";
        }
         //echo "$i"; 
    }
/*
    echo "$studentattemptsSQL";
*/
    $studentattempts = sqlsrv_query($con, $studentattemptsSQL, $params, $options);
    if ($studentattempts === false)
        die(print_r(sqlsrv_errors(), true));
}
else
{
    echo "Data Error";
}
?>