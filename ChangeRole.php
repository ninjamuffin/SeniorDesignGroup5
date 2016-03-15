<?php

include 'base.php';

$params = array($_SESSION['Username']);
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET);
$ListRolesQuery = "SELECT DISTINCT R.Role, R.Designation, R.RoleID, R.Type FROM Roles as R, RoleInstances as RI WHERE RI.SiteUsername = ? AND RI.RoleID = R.RoleID ORDER BY R.RoleID, R.Designation, R.Type";
$stmt = sqlsrv_query($con, $ListRolesQuery, $params, $options);
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}

// Make the first (and in this case, only) row of the result set available for reading.
$RolesList = [];
$Designations = [];
$AccessPriv = [];
while( sqlsrv_fetch( $stmt ) === true) {
    $RolesList[] = sqlsrv_get_field( $stmt, 0);
    $AccessPriv[] = sqlsrv_get_field( $stmt, 3);
}


$targetRole = $_GET['q'];
$targetAccessType = $_GET['t'];

$index = 0;
$valid = false;
foreach($RolesList as $ListedRole)
{
    if ($ListedRole == $targetRole)
    {
        
        if ($AccessPriv[$index] == $targetAccessType)
        {
            $valid = true;
            $_SESSION['Role'] = $targetRole;
            $_SESSION['AccessType'] = $targetAccessType;
            echo "<meta http-equiv='refresh' content='0;/$targetRole/Home' />";
        }
    }
    $index++;
}
if (!($valid))
{
    echo "<meta http-equiv='refresh' content='0;/Logout.php' />";
}


?>
