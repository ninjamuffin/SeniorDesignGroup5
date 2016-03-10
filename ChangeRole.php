<?php

include 'base.php';

$q = $_GET['q'];
$t = $_GET['t'];

$_SESSION['Role'] = $q;
$_SESSION['AccessType'] = $t;
$role = $_SESSION['Role'];

echo "<meta http-equiv='refresh' content='0;/$role/Home' />";
?>
