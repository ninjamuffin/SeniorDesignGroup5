<html>
<body>
 

<?php
$con = mysqli_connect('us-cdbr-azure-west-c.cloudapp.net','b2a3214e88e413','325ebc40','mysqldbproject');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

$sql="INSERT INTO user (FirstName, LastName, Age, Hometown, Job)
VALUES
('FirstName' , 'LastName' , 'Age' , 'Hometown' , 'Job')";
 
if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
echo "1 record added";
 
mysql_close($con)

?>
</body>
</html>
