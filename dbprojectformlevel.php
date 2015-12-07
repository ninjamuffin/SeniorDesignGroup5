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

$con = mysqli_connect('us-cdbr-azure-west-c.cloudapp.net','b2a3214e88e413','325ebc40','mysqldbproject');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
if ($q == "expressions"){

mysqli_select_db($con,"mysqldbproject");
$sql="SELECT * FROM expressions";
$result = mysqli_query($con,$sql);
echo ($q);
echo "<table>
<tr>
<th>student_id</th>
<th>expression</th>
<th>level_id</th>
<th>topic_id</th>
<th>language_id</th>
</tr>";


while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['student_id'] . "</td>";
    echo "<td>" . $row['expression'] . "</td>";
    echo "<td>" . $row['level_id'] . "</td>";
    echo "<td>" . $row['topic_id'] . "</td>";
    echo "<td>" . $row['language_id'] . "</td>";
    echo "</tr>";
}

if ($q == "language"){

mysqli_select_db($con,"mysqldbproject");
$sql="SELECT * FROM language";
$result = mysqli_query($con,$sql);
echo ($q);
echo "<table>
<tr>
<th>language_id</th>
<th>language_name</th>
</tr>";


while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['language_id'] . "</td>";
    echo "<td>" . $row['language_name'] . "</td>";
    echo "</tr>";
}

echo "</table>";
mysqli_close($con);
}
?>
</body>
</html>
