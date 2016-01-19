<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}
table, td, th{
    border: 2px solid black;
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
//get the q parameter from URL
$q=$_GET["q"];
// connects to DB
$serverName = "o0tvd0xlpb.database.windows.net,1433";
$connectionInfo = array( "Database"=>"SmalltalkMigrate2.0", "UID"=>"CS05", "PWD"=>"!1Elcwebapp");
$con = sqlsrv_connect( $serverName, $connectionInfo);
if (!$con) {
    die( print_r( sqlsrv_errors(), true));
}
//Search results for echo ($q);
    
$sql= "SELECT * FROM dbo.Students WHERE ID < 100";
//echo ($sql);  //Tests the sql statement
$result = sqlsrv_query($con,$sql);
//Create table template
echo "<table>
<caption>Search Results:</caption>
<tr>
<th>Student ID</th>
<th>Last Name</th>
<th>First Name</th>
<th>Nickname</th>
<th>Citizenship</th>
<th>Language</th>
</tr>";
//Input values into table
while($row = sqlsrv_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['ID'] . "</td>";
    echo "<td>" . $row['Last Name'] . "</td>";
    echo "<td>" . $row['First Name'] . "</td>";
    echo "<td>" . $row['Nickname'] . "</td>";
    echo "<td>" . $row['Citizenship'] . "</td>";
    echo "<td>" . $row['Language'] . "</td>";
    echo "</tr>";
}
//output the table with values in it
echo "</table>";
sqlsrv_close($con);
?>
</body>
</html>