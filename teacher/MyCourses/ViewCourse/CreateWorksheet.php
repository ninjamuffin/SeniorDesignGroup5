<?php

include '../../../base.php';

function get_topic_id($topic)
{
    $params = array($topic);
    $options = array( "Scrollable" => 'static');
    $addTopicSQL = "INSERT into Topics Values (?)";
    $getTopicIDSQL = "SELECT TOP 1 TopicID FROM Topics 
                        WHERE Topic = ?
                        ORDER BY TopicID Desc";
    $TopicID = 0;
    $addTopic = sqlsrv_query($con, $addTopicSQL, $params, $options);
    if($addTopic === false)
        die(print_r(sqlsrv_errors(), true));
    
    $getTopicID = sqlsrv_query($con, $getTopicIDSQL, $params, $options);
    if($getTopicID === false)
        die(print_r(sqlsrv_errors(), true));
    if(sqlsrv_fetch($getTopicID) === true)
        $TopicID = sqlsrv_get_field($getTopicID, 0);
    return $TopicID;
}

if ((isset($_POST['worksheet_number'])) && (isset($_POST['topic'])))
{
    $original = isset($_POST['worksheetTypeOriginal']) ? $_POST['worksheetTypeOriginal'] : 'off';
    $text_ref = isset($_POST['worksheetTypeText']) ? $_POST['worksheetTypeText'] : 'off';
    $audio_ref = isset($_POST['worksheetTypeAudio']) ? $_POST['worksheetTypeAudio'] : 'off';
    
    
    $original_bool = 0;
    $text_ref_bool = 0;
    $audio_ref_bool = 0;
    if ($original != 'off')
        $original_bool = 1;
    if ($text_ref != 'off')
        $text_ref_bool = 1;
    if ($audio_ref != 'off')
        $audio_ref_bool = 1;
    
    $params = array($_POST['topic']);
    $options = array( "Scrollable" => 'static');
    $addTopicSQL = "INSERT into Topics Values (?)";
    $getTopicIDSQL = "SELECT TOP 1 TopicID FROM Topics 
                        WHERE Topic = ?
                        ORDER BY TopicID Desc";
    $TopicID = 887;
    $addTopic = sqlsrv_query($con, $addTopicSQL, $params, $options);
    if($addTopic === false)
        die(print_r(sqlsrv_errors(), true));
    
    $getTopicID = sqlsrv_query($con, $getTopicIDSQL, $params, $options);
    if($getTopicID === false)
        die(print_r(sqlsrv_errors(), true));
    if(sqlsrv_fetch($getTopicID) === true)
        $TopicID = sqlsrv_get_field($getTopicID, 0);
    
    $params = array($_POST['courseid'], $_POST['worksheet_number'], $TopicID, $original_bool, $text_ref_bool, $audio_ref_bool);
    $options = array( "Scrollable" => 'static');
    
    $newworksheetSQL = "INSERT INTO Worksheets (
            [Date]
           ,[CourseID]
           ,[WorksheetNumber]
           ,[EditStatus]
           ,[TopicID]
           ,[DisplayOriginal]
           ,[DisplayTextReformulation]
           ,[DisplayAudioReformulation]) VALUES (GETDATE(), ?, ?, 'Unreleased', ?, ?, ?, ?)";
    
    $newworksheet = sqlsrv_query($con, $newworksheetSQL, $params, $options);
    if($newworksheet === false)
        die(print_r(sqlsrv_errors(), true));
}

?>