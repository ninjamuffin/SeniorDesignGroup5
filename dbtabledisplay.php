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

$con = mysqli_connect('o0tvd0xlpb.database.windows.net','CS05','!1Elcwebapp','Expression Errors');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"Expression Errors");
$sql="SELECT * FROM dbo.registration_tbl WHERE name = '".$q."'";
$result = mysqli_query($con,$sql);

echo "<table>
<tr>
<th>Name</th>
<th>Email</th>
<th>Date</th>
</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['date'] . "</td>";
    echo "</tr>";
}
echo "</table>";
mysqli_close($con);
?>
</body>
</html>