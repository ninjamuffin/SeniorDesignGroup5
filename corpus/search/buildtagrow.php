<?php

include '../../base.php';

if (isset($_POST['tags']))
{
    $tags = $_POST['tags'];
?>
    <tr>
        <td>Tag</td>
        <td>
        <?php
        $i = 0;
        while (($i < 3) && ($i < count($tags) - 1))
        {
            ?>
                <?=$tags[$i]?>/
            <?php
                $i++;
        }
    ?>
            <?=$tags[$i]?>
        <?php
            if (count($tags) > 4)
            {
                ?>
                ...
                <?php
            }?>
        </td>
        <td>
            <button class='btn btn-danger' type='button' name='DeleteRow'>
                Delete
            </button>
        </td>
<?php
    foreach($tags as $tag)
    {
        ?>
        <input hidden name="<?=$tags[0]?>[]" value="<?=$tag?>">
        <?php
    }
    ?>
    </tr>
<?php
}
else
{
    ?>
    <p>ERRORRRRRR</p>
<?php
}
?>