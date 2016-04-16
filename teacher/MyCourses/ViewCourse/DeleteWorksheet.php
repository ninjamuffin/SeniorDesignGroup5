<?php

include '../../../base.php';

if(isset($_POST['worksheetID']))
{
    $params = array($_POST['worksheetID']);
    $options = array( "Scrollable" => 'static' );
    $deleteworksheetSQL = "UPDATE Worksheets SET IsDeleted = 1 WHERE WorksheetID = ?";
    $deleteworksheet = sqlsrv_query($con, $deleteworksheetSQL, $params, $options);
    if ($deleteworksheet === false)
        die(print_r(sqlsrv_errors(), true));
}