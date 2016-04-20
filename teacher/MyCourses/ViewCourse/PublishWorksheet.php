<?php
    include '../../../base.php';

    if (isset($_POST['worksheetID']))
    {
        $worksheetID = $_POST['worksheetID'];
        $params = array($worksheetID);
        $options = array("Scrollable" => 'static');
        $publishworksheetSQL = "UPDATE Worksheets SET EditStatus='Released' WHERE WorksheetID = ?";
        $publishworksheet = sqlsrv_query($con, $publishworksheetSQL, $params, $options);
        if ($publishworksheet === false)
            die(print_r(sqlsrv_errors(), true));
    }
    else
    {
        echo "Data Error";
    }
?>