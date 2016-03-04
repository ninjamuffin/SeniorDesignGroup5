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
// connects to DB
$con = mysqli_connect('us-cdbr-azure-west-c.cloudapp.net','b2a3214e88e413','325ebc40','mysqldbproject');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

echo $q;

    
//Search results for echo ($q);
mysqli_select_db($con,"mysqldbproject");
$sql= "SELECT * FROM expressions_full WHERE expression LIKE '%{$q}%'";
//echo ($sql);  //Tests the sql statement
$result = mysqli_query($con,$sql);
//Create table template
// echo "<table>
// <caption>Search Results:</caption>
// <tr>
// <th>student_id</th>
// <th>expression</th>
// <th>level_id</th>
// <th>topic_id</th>
// <th>language_id</th>
// </tr>";
//Input values into table
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['expression_id'] . "</td>";
    echo "<td>" . $row['expression'] . "</td>";
    echo "<td>" . $row['level_id'] . "</td>";
    echo "<td>" . $row['topic_id'] . "</td>";
    echo "<td>" . $row['language_id'] . "</td>";
    echo "</tr>";
}
//output the table with values in it
echo "</table>";

mysqli_close($con);
?>
</body>
</html>
