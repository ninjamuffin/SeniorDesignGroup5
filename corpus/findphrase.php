<?php
if (isset($_POST['search'])) {
        $search = htmlentities($_POST['search']);
 
$con = mysqli_connect('us-cdbr-azure-west-c.cloudapp.net','b2a3214e88e413','325ebc40','mysqldbproject');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

echo($echo);
   
//Search results for echo ($q);
mysqli_select_db($con,"mysqldbproject");
$sql= "SELECT * FROM expressions_full WHERE  expression LIKE '$search%'";
$req =  mysqli_query($con,$sql) or die();
echo '<ul>';
while ($row = mysqli_fetch_array($req))
{
      echo '<li><a href="#" onclick="selected(this.innerHTML);">'.htmlentities($row['expression']).'</a></li>';
}
echo '</ul>';
mysqli_close($con);
exit;
}
?>
