<?php
session_start();

$dbhost = "o0tvd0xlpb.database.windows.net,1433";
$dbname = "Smalltalk Migrate 2.0";
$dbuser = "CS05";
$dbpass = "!1Elcwebapp";
$connectionInfo = array( "Database"=>$dbname, "UID"=>$dbuser, "PWD"=>$dbpass);

$con = sqlsrv_connect($dbhost, $connectionInfo); if(!$con) {
    die(print_r(sqlsrv_errors(), true));
}

function mssql_escape($data) {
    if(is_numeric($data))
        return $data;
    $unpacked = unpack('H*hex', $data);
    return '0x' . $unpacked['hex'];
}

?>