<?php

include 'base.php';

$q = $_GET['q'];

$_SESSION['Role'] = $q;
$role = $_SESSION['Role'];

echo "<meta http-equiv='refresh' content='0;/$role/Home' />";
?>
