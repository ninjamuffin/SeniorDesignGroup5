<?php
$con = mysqli_connect('us-cdbr-azure-west-c.cloudapp.net','b2a3214e88e413','325ebc40','mysqldbproject');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
 
// Escape user inputs for security
$first_name = mysqli_real_escape_string($link, $_POST['firstname']);
$last_name = mysqli_real_escape_string($link, $_POST['lastname']);
$age = mysqli_real_escape_string($link, $_POST['age']);
$hometown = mysqli_real_escape_string($link, $_POST['hometown']);
$job = mysqli_real_escape_string($link, $_POST['job']);
 
// attempt insert query execution
$sql = "INSERT INTO persons (FirstName, LastName, Age, Hometown, Job) VALUES ('$first_name', '$last_name', '$age', '$hometown', '$job')";
if(mysqli_query($link, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// close connection
mysqli_close($link);
?>
