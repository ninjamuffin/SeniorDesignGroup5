<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}
table, td, th {
    border: 1px solid black;
    padding: 5px;
}
th {text-align: left;}
</style>
</head>
<body>

<?php
$q = strval($_GET['q']);
$serverName = "o0tvd0xlpb.database.windows.net,1433";
$connectionInfo = array( "Database"=>"SmalltalkMigrate2.0", "UID"=>"CS05", "PWD"=>"!1Elcwebapp");
$con = sqlsrv_connect( $serverName, $connectionInfo);
if (!$con) {
    die( print_r( sqlsrv_errors(), true));
}

if ($q == "expressions"){
sqlsrv_select_db($con,"!1Elcwebapp");
$sql="SELECT * FROM expressions";
//echo ($sql);
$result = sqlsrv_query($con,$sql);
echo "<center>$q Table</center>";
echo "<table>
<tr>
<th>student_id</th>
<th>expression</th>
<th>level_id</th>
<th>topic_id</th>
<th>language_id</th>
</tr>";
while($row = sqlsrv_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['student_id'] . "</td>";
    echo "<td>" . $row['expression'] . "</td>";
    echo "<td>" . $row['level_id'] . "</td>";
    echo "<td>" . $row['topic_id'] . "</td>";
    echo "<td>" . $row['language_id'] . "</td>";
    echo "</tr>";
}
echo "</table>";
}
if ($q == "language"){
sqlsrv_select_db($con,"!1Elcwebapp");
$sql="SELECT * FROM language";
$result = sqlsrv_query($con,$sql);
echo "<center>$q Table</center>";
echo "<table>
<tr>
<th>language_id</th>
<th>language_name</th>
</tr>";
while($row = sqlsrv_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['language_id'] . "</td>";
    echo "<td>" . $row['language_name'] . "</td>";
    echo "</tr>";
}
echo "</table>";
}
if ($q == "topic"){
sqlsrv_select_db($con,"!1Elcwebapp");
$sql="SELECT * FROM topic";
$result = sqlsrv_query($con,$sql);
echo "<center>$q Table</center>";
echo "<table>
<tr>
<th>topic_id</th>
<th>topic_name</th>
</tr>";
while($row = sqlsrv_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['topic_id'] . "</td>";
    echo "<td>" . $row['topic_name'] . "</td>";
    echo "</tr>";
}
echo "</table>";
}
if ($q == "word"){
sqlsrv_select_db($con,"!1Elcwebapp");
$sql="SELECT * FROM word";
$result = sqlsrv_query($con,$sql);
echo "<center>$q Table</center>";
echo "<table>
<tr>
<th>word_id</th>
<th>word_name</th>
</tr>";
while($row = sqlsrv_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['word_id'] . "</td>";
    echo "<td>" . $row['word_name'] . "</td>";
    echo "</tr>";
}
echo "</table>";
}
if ($q == "level"){
sqlsrv_select_db($con,"!1Elcwebapp");
$sql="SELECT * FROM level";
$result = sqlsrv_query($con,$sql);
echo "<center>$q Table</center>";
echo "<table>
<tr>
<th>Level</th>
<th>Level Description</th>
</tr>";
while($row = sqlsrv_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['Level'] . "</td>";
    echo "<td>" . $row['Level Description'] . "</td>";
    echo "</tr>";
}
echo "</table>";
}
sqlsrv_close($con);
?>
</body>
</html>
