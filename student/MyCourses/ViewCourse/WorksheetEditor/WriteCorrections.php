<?php
include '../../../../base.php';

if (isset($_POST['worksheetID']) && isset($_POST['expressionIDs']) && isset($_POST['correctedText']) && isset($_POST['enrollmentID']) && isset($_POST['isAltered']))
{
    $worksheetID = $_POST['worksheetID'];
    $expressionIDs = $_POST['expressionIDs'];
    $correctedText = $_POST['correctedText'];
    $enrollmentID = $_POST['enrollmentID'];
    $isAltered = $_POST['isAltered'];
    
    
    $params = array($worksheetID, $enrollmentID);
    $options = array("Scrollable" => 'static');
    $getattemptnumberSQL = "SELECT count(AttemptNumber) 
                         FROM StudentSubmissions 
                         WHERE WorksheetID = ? AND EnrollmentID = ?";
    $getattemptnumber = sqlsrv_query($con, $getattemptnumberSQL, $params, $options);
    if ($getattemptnumber === false)
        die(print_r(sqlsrv_errors(), true));
    if (sqlsrv_fetch($getattemptnumber) === true)
        $attemptNumber = sqlsrv_get_field($getattemptnumber, 0);
    $attemptNumber = $attemptNumber + 1;

/*
     Write to student submissions 
*/
    $params = array($enrollmentID, $worksheetID, $attemptNumber);
    $studentsubmissionsSQL = "INSERT INTO StudentSubmissions VALUES (?, ?, ?, 0, GETDATE())";
    $studentsubmissions = sqlsrv_query($con, $studentsubmissionsSQL, $params, $options);
    if ($studentsubmissions === false)
        die(print_r(sqlsrv_errors(), true));

    $getstudentsubmissionidSQL = "SELECT DISTINCT StudentSubmissionID FROM StudentSubmissions
                            WHERE EnrollmentID = ? AND
                                  WorksheetID = ? AND
                                  AttemptNumber = ?";
    $getstudentsubmissionid = sqlsrv_query($con, $getstudentsubmissionidSQL, $params, $options);
    if ($getstudentsubmissionid === false)
        die(print_r(sqlsrv_errors(), true));
    while(sqlsrv_fetch($getstudentsubmissionid) === true)
        $studentsubmissionid = sqlsrv_get_field($getstudentsubmissionid, 0);

    
    
    
    $studentattemptsSQL = "INSERT INTO StudentAttempts (ExpressionID, StudentSubmissionID, ReformulationText, AttemptNumber, completed) VALUES ";
    $numExpressions = count($expressionIDs);
    //echo "$numExpressions";
    //echo "($expressionIDs[0], $studentsubmissionid, $correctedText[0])";
    for($i = 0; $i < $numExpressions; $i++)
    {
        if ($i == $numExpressions - 1)
        {
            if ($isAltered[$i] == 1)
                $studentattemptsSQL = $studentattemptsSQL . "($expressionIDs[$i], $studentsubmissionid, '$correctedText[$i]', $attemptNumber, 1)";
            else
                $studentattemptsSQL = substr($studentattemptsSQL, 0, strlen($studentattemptsSQL) - 2);
        }
        else
        {
            if ($isAltered[$i] == 1)
                $studentattemptsSQL = $studentattemptsSQL . "($expressionIDs[$i], $studentsubmissionid, '$correctedText[$i]', $attemptNumber, 1), ";
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