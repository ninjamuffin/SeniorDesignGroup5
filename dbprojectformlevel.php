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
$q = $_GETintval(['q']);

$con = mysqli_connect('us-cdbr-azure-west-c.cloudapp.net','b2a3214e88e413','325ebc40','mysqldbproject');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"mysqldbproject");
$sql="SELECT * FROM expressions WHERE student_id = '".$q."'"";
$result = mysqli_query($con,$sql);

echo "<table>
<tr>
<th>student_id</th>
<th>Expression</th>
<th>Level</th>
<th>Topic</th>
<th>Language</th>
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
echo "</table>";
mysqli_close($con);
?>
</body>
</html>
