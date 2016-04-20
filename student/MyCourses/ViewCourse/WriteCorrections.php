<?php
    include '../../../base.php';

    if (isset($_POST['worksheetID']))
    {
        $worksheetID = $_POST['worksheetID'];
        $expressionIDs[] = $_POST['expressionIDs'];
        $correctedText[] = $_POST['correctedText'];
        $enrollmentID = $_POST['enrollmentID'];
        $params = array($enrollmentID, $worksheetID);
        $options = array("Scrollable" => 'static');
        
        $studentsubmissionsSQL = "INSERT INTO StudentSubmissions (?, ?, 1, 0, GETDATE())";
        $studentsubmissions = sqlsrv_query($con, $studentsubmissionsSQL, $params, $options);
        if ($studentsubmissionsid === false)
            die(print_r(sqlsrv_errors(), true));
        
        $getstudentsubmissionidSQL = "SELECT StudentSubmissionID FROM StudentSubmissions
                                WHERE EnrollmentID = ? AND
                                      WorksheetID = ? AND
                                      AttemptNumber = 1";
        $getstudentsubmissionid = sqlsrv_query($con, $studentsubmissionidSQL, $params, $options);
        if ($getstudentsubmissionid === false)
            die(print_r(sqlsrv_errors(), true));
        while(sqlsrv_fetch($getstudentsubmissionid) === true)
            $studentsubmissionid = sqlsrv_get_field($getstudentsubmissionid, 0);
        
        $studentattemptsSQL = "INSERT INTO StudentAttempts (ExpressionID, StudentSubmissionID, ReformulationText) VALUES ";
        for($i = 0; $i < $expressionIDs.count(); $i++)
        {
            if ($i == $expressionIDs.count() - 1)
            {
                $studentattemptsSQL = $studentattemptsSQL . "($expressionIDs[$i], $studentsubmissionid, $correctedText[$i])";    
            }
            $studentattemptsSQL = $studentattemptsSQL . "($expressionIDs[$i], $studentsubmissionid, $correctedText[$i]), ";
        }
        $studentattempts = sqlsrv_query($con, $studentattemptsSQL, $params, $options);
        if ($studentattempts === false)
            die(print_r(sqlsrv_errors(), true));
        
    else
    {
        echo "Data Error";
    }
?>