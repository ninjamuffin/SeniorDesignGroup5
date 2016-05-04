<?php
// Array with names

include '../../base.php';

if (!(empty($_POST['new_tag'])))
{
?>
    <table class='table table-hover'><thead><tr>
    <th><label><input type='checkbox' id='checkAll'> Select All </label></th><th>Tag Name</th><th>Tag Type</th><th>Frequency</th>
    </tr></thead><tbody>
<?php
    
    if ($_POST['new_tag'] == "ALL")
    {
        $query = "SELECT TOP 20 Frequency, Tag, TagType FROM CLAWS7 ORDER BY Frequency desc";
        $params = array();
    }
    else
    {
        $query = "SELECT Frequency, Tag, TagType FROM CLAWS7 WHERE TagType = ? ORDER BY Frequency desc";
        $params = array($_POST['new_tag']);
    }

    $options = array( "Scrollable" => 'static' );
    
    $stmt = sqlsrv_query($con, $query, $params, $options);
    if ($stmt === false)
        die(print_r(sqlsrv_errors(), true));
    $length = sqlsrv_num_rows($stmt);
    $tag_names = [];
    $tag_type = [];
    $frequency = [];

    while (sqlsrv_fetch($stmt) === true)
    {
        $frequency[] = sqlsrv_get_field($stmt, 0);
        $tag_names[] = sqlsrv_get_field($stmt, 1);
        $tag_type[] = sqlsrv_get_field($stmt, 2);

    }

    for ($i = 0; $i < $length; $i++)
    {
        $tag = $tag_names[$i];
        $freq = $frequency[$i];
        $type = $tag_type[$i];
        ?>
        <tr>
            <td><input type='checkbox' name='checktags[]' value="<?=$tag?>"></td>
            <td><?=$tag?></td>
            <td><?=$type?></td>
            <td><?=$freq?></td>
            <input hidden type="text" name="tags[]" value="<?=$tag?>">
            <?php
    }?>
    </tbody></table>
<?php
}

else
{
?>
<p>No data received</p>
<?php
}

?>
