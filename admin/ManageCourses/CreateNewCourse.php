<?php

include '../../base.php';

if ( (isset($_POST['institutionID'])) && (isset($_POST['sessionID'])) && (isset($_POST['coursetypeID'])) && (isset($_POST['section'])) && (isset($_POST['teacherID'])) )
{
    $institutionID = $_POST['institutionID'];
    $sessionID = $_POST['sessionID'];
    $coursetypeID = $_POST['coursetypeID'];
    $section = $_POST['section'];
    $teacherID = $_POST['teacherID'];
    
    
    $params = array($institutionID, $sessionID, $coursetypeID, $section, $teacherID);
    $options = array( "Scrollable" => 'static' );
    
    $createcourseSQL = "INSERT INTO Courses (CourseTypesID, SessionInstanceID, InstitutionID, TeachingInstanceID, Section, Status)
                        VALUES (?,?,?,?,?,'Active')";
    $createcourse = sqlsrv_query($con, $createcourseSQL, $params, $options);
    if ($createcourse === false)
        die(print_r(sqlsrv_errors(), true));
}
else
    echo "No data";
?>