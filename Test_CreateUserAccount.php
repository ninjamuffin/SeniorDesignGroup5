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
//get the q parameter from URL
$q=$_POST["q"];
$r=$_POST["r"];
$email=$_POST["email"];
// connects to DB
$serverName = "o0tvd0xlpb.database.windows.net,1433";
$connectionInfo = array( "Database"=>"SmalltalkMigrate2.0", "UID"=>"CS05", "PWD"=>"!1Elcwebapp");
$con = sqlsrv_connect( $serverName, $connectionInfo);
if (!$con) {
    die( print_r( sqlsrv_errors(), true));
}
    
$sql="INSERT INTO SiteUsers (username, email, role, date_added) VALUES ('$q', '$email','$r',GETDATE())";
echo ($sql);  //Tests the sql statement
$result = sqlsrv_query($con,$sql);
echo ($result);

//display users table
$table_sql = "SELECT * from SiteUsers";
$table_result = sqlsrv_query($con,$table_sql);
//Create table template
echo "<table>
<caption>Users Table:</caption>
<tr>
<th>user_id</th>
<th>username</th>
<th>email address</th>
<th>role</th>
</tr>";
//Input values into table
while($row = sqlsrv_fetch_array($table_result)) {
    echo "<tr>";
    echo "<td>" . $row['user_id'] . "</td>";
    echo "<td>" . $row['username'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['role'] . "</td>";
    echo "</tr>";
}
//output the table with values in it
echo "</table>";

sqlsrv_close($con);
?>
</body>
</html>