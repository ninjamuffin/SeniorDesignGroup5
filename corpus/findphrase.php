<?php
$dbHost = 'us-cdbr-azure-west-c.cloudapp.net';
$dbUsername = 'b2a3214e88e413';
$dbPassword = '325ebc40';
$dbName = 'mysqldbproject';

//"SELECT * FROM expressions_full WHERE expression LIKE '%{$q}%'";
	
	$q=$_GET['q'];
	$my_data=mysql_real_escape_string($q);
	$mysqli=mysqli_connect($dbHost,$dbUsername,$dbPassword,$dbName) or die("Database Error");
	$sql="SELECT expression FROM expressions_full WHERE expression LIKE '%$my_data%'";
	$result = mysqli_query($mysqli,$sql) or die(mysqli_error());
	
	if($result)
	{
		while($row=mysqli_fetch_array($result))
		{
			echo $row['name']."\n";
		}
	}
?>
