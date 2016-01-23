<!DOCTYPE html>
<html>
<head>
<style type="text/css">
table {
    width: 100%;
    border-collapse: collapse;
}
table, td, th{
    border: 1px solid black;
    padding: 5px;
}
caption {
    display: table-caption;
    text-align: center;
}
th {text-align: left;}
    
</style>
</head>
<body>

<?php
//get the q and r parameters from URL
$q=$_POST["q"];
$r=$_POST["r"];

echo ($q);
echo ($r);