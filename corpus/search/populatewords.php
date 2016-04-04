<?php
// Array with names

include '../../base.php';

if (!(empty($_POST['new_word'])))
{
    $query_valid = false;
    if ( strlen($_POST['new_word']) > 0 )
        $query_valid = true;

    if ( $query_valid)
    {
    ?>
        <table class='table table-hover'><thead><tr>
        <th><label><input type='checkbox' id='checkAll'> Select All </label></th><th>Form</th><th>Tag</th><th>Frequency</th></tr></thead>
        <?php
        $query = "SELECT WordID, Form, PoS, Frequency FROM Dictionary WHERE Form= ?";

        $options = array( "Scrollable" => 'static' );
        $params = array($_POST['new_word']);
        $word = $_POST['new_word'];
        

        $stmt = sqlsrv_query($con, $query, $params, $options);
        if ($stmt === false)
            die (print_r(sqlsrv_errors(), true));
        $result_length = sqlsrv_num_rows($stmt);
        $ids = [];
        $forms = [];
        $tags = [];
        $freq = [];
        while (sqlsrv_fetch($stmt) === true)
        {
            $ids[] = sqlsrv_get_field($stmt, 0);
            $forms[] = sqlsrv_get_field($stmt, 1);
            $tags[] = sqlsrv_get_field($stmt, 2);
            $freq[] = sqlsrv_get_field($stmt, 3);
        }
        ?>
            <tbody>
                <input hidden name="searchedword" value="<?=$word?>">
        <?php
        for ($i = 0; $i < $result_length; $i++)
        {
            $id = $ids[$i];
            ?>
            <tr>
                
                <td><input type="checkbox" name="checkwords[]" value="<?=$id?>"></td>
                <td><?=$forms[$i]?></td>
                <td><?=$tags[$i]?></td>
                <td><?=$freq[$i]?></td>
                <input hidden type="text" name="words[]" value="<?=$id?>">
                
            </tr>
            <?php
        }
        ?>
            </tbody></table>

<?php
    }
    else
    {
        ?>
        <p>No data received</p>
<?php
    }
}
?>
