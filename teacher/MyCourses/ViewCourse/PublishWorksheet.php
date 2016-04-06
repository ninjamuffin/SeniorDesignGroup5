<?php
include '../../../base.php';

$worksheetID = isset($_POST['worksheetid']) ? $_POST['worksheet'] : 0;
$courseID = isset($_POST['courseid']) ? $_POST['courseid'] : 0;
if ( ($worksheetID == 0) && ($courseID == 0))
    echo "<meta http-equiv='refresh' content='0;/' />";
else
{
    echo "PublishWorksheet Script";
    echo "<meta http-equiv='refresh' content='2;/' />";
}
