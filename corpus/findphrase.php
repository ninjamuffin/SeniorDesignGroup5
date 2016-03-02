<?php
if (isset($_POST['search'])) {
        $search = htmlentities($_POST['search']);
 
$db = mysql_connect('us-cdbr-azure-west-c.cloudapp.net','b2a3214e88e413','325ebc40'); //Don't forget to change
mysql_select_db('mysqldbproject', $db);             //theses parameters
$sql = "SELECT expression from expressions_full WHERE expression LIKE '$search%'";
$req = mysql_query($sql) or die();
echo '<ul>';
while ($data = mysql_fetch_array($req))
{
      echo '<li><a href="#" onclick="selected(this.innerHTML);">'.htmlentities($data['expression']).'</a></li>';
}
echo '</ul>';
mysql_close();
exit;
}
?>
