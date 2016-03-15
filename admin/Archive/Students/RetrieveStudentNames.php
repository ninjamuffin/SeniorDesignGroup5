<?php

include '../../../base.php';

if(!empty($_POST["keyword"]))
{
    $query = "SELECT DISTINCT TOP 6 LastName FROM Students WHERE LastName LIKE '" . $_POST["keyword"] . "%' AND ID in (SELECT DISTINCT ES.Student_ID FROM Expressions as ES) ORDER BY LastName";
    $options = array( "Scrollable" => 'static');
    $params = array();
    $stmt = sqlsrv_query($con, $query, $params, $options);
    if ($stmt === false)
        die(print_r(sqlsrv_errors(), true));
    $names = [];
    while (sqlsrv_fetch($stmt) === true)
    {
        $names[] = sqlsrv_get_field($stmt, 0);
    }

    if(!empty($names))
    {
        ?>
<ul id="names-list">
    <?php
        foreach($names as $name)
        {?>
    <li onClick="selectName('<?=$name?>');"><?=$name?></li>
        <?php 
        }
        ?>
    </ul>
<?php
    }
}

?>
