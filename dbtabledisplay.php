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
$q = intval($_GET['q']);
$server = 'o0tvd0xlpb.database.windows.net,1433';
$con = mssql_connect($server,'CS05','!1Elcwebapp');
if (!$con) {
    die('Could not connect: ' . mssql_get_last_message());
}

mssql_select_db("Expression Errors", $con);
$sql="SELECT * FROM dbo.registration_tbl WHERE id = '".$q."'";
$result = mssql_query($sql);

echo "<table>
<tr>
<th>Name</th>
<th>Email</th>
<th>Date</th>
</tr>";
while($row = mssql_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['date'] . "</td>";
    echo "</tr>";
}
echo "</table>";
mssql_close($con);
?>
</body>
</html>