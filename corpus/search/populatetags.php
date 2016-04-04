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
        $query = "SELECT TOP 10 sum(Frequency), PoS FROM Dictionary WHERE PoS in (SELECT Tag FROM CLAWS7) GROUP BY PoS ORDER BY sum(Frequency) desc";
    }
    else
    {
        $query = "SELECT TOP 10 sum(Frequency), PoS FROM Dictionary WHERE PoS in (SELECT Tag FROM CLAWS7) GROUP BY PoS ORDER BY sum(Frequency) desc";
    }

    $options = array( "Scrollable" => 'static' );
    $params = array();
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
        $tag_type[] = "Undetermined";

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
