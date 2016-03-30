<?php

include '../../../base.php';

if(!empty($_POST["keyword"]))
{
    $query = "SELECT TOP 8 S.FirstName,S.LastName,min(Y.Year), max(Y.Year), S.ID
    FROM Students as S, Year as Y, Enrollment as E, Courses as TC, Sessions as Ss 
    WHERE S.LastName LIKE '" . $_POST["keyword"] . "%' AND 
          S.ID in (SELECT DISTINCT ES.Student_ID FROM Expressions as ES) AND 
          E.StudentID = S.ID AND
          TC.CoursesID = E.ClassInstanceID AND
          Ss.SessionsID = TC.SessionID AND
          Y.ID = Ss.Year_ID
    GROUP BY S.FirstName, S.LastName, S.ID";
    $options = array( "Scrollable" => 'static');
    $params = array();
    $stmt = sqlsrv_query($con, $query, $params, $options);
    if ($stmt === false)
        die(print_r(sqlsrv_errors(), true));
    $fnames = [];
    $lnames = [];
    $minyears = [];
    $maxyears = [];
    $ids = [];
    while (sqlsrv_fetch($stmt) === true)
    {
        $fnames[] = sqlsrv_get_field($stmt, 0);
        $lnames[] = sqlsrv_get_field($stmt, 1);
        $minyears[] = sqlsrv_get_field($stmt, 2);
        $maxyears[] = sqlsrv_get_field($stmt, 3);
        $ids[] = sqlsrv_get_field($stmt, 4);
    }

    if(!empty($lnames))
    {
        ?>
<style>
    span.highlight {
        background-color: rgb(160,189,81);
    }
</style>
<ul id="names-list" style="max-height:300px;overflow-y:scroll">
    <?php
        $i = 0;
        foreach($lnames as $lname)
        {
    ?>
            
    <li onClick="selectName('<?=$ids[$i]?>');"><?=$fnames[$i]?> <strong><?=$lname?></strong> <span class="pull-right"><small class="text-muted" style="color:white;right:0px; "><?=$minyears[$i]?> - <?=$maxyears[$i]?></small></span></li>
        <?php 
            $i++;
        }
        ?>
    </ul>
<?php
    }
    else
    {
        ?>
<ul id="names-list">
    <li>There are no matches to your search</li>
    
</ul>    
    <?php
    }
}

?>
