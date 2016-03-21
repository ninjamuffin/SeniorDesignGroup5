<?php
// Array with names

include '../../base.php';


if(!(empty($_POST['keyword']))){
    

    $params = array($_POST['keyword']);
    $options = array( "Scrollable" => 'static' );
    $query ="SELECT Top 6 Tag FROM [CLAWS7] WHERE Tag like '" . $_POST["keyword"] . "%' ORDER BY Tag";
    $stmt = sqlsrv_query($con, $query, $params, $options);
    if ($stmt === false)
        die(print_r(sqlsrv_errors(), true));
    $tags = [];
/*
    $ids = [];
*/
    while (sqlsrv_fetch($stmt) === true)
    {
        $tags[] = sqlsrv_get_field($stmt, 0);
/*
        $ids[] = sqlsrv_get_field($stmt, 1);
*/
    }
    $length = sqlsrv_num_rows($stmt);

    if(!empty($tags)) {
    ?>
        <ul id="tags-list" class="form-control">
        <?php
            for($i = 0; $i < $length; $i++) 
            {
                ?>
                <li onClick="selectTag('<?=$tags[$i]?>');">
                    <?=$tags[$i]?>
                </li>
                <?php 
            } ?>
        </ul>
    <?php } }
?>
