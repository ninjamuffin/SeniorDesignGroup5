<html>
<body>
 

<?php
$con = mysqli_connect('us-cdbr-azure-west-c.cloudapp.net','b2a3214e88e413','325ebc40','mysqldbproject');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

$sql_insert ="INSERT INTO user (FirstName, LastName, Age, Hometown, Job)
VALUES (?,?,?,?,?)";
#<!--'FirstName' , 'LastName' , 'Age' , 'Hometown' , 'Job'-->
$stmt = $conn->prepare($sql_insert);
$stmt -> bindValue(1, $FirstName);
$stmt -> bindValue(2, $LasttName);
$stmt -> bindValue(3, $Age);
$stmt -> bindValue(4, $Hometown);
$stmt -> bindValue(5, $Job);
$stmt -> execute();

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
echo "1 record added";
 
mysql_close($con)

?>
</body>
</html>
