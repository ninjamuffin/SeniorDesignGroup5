<?php
// Array with names

include '../../base.php';

if ((isset($_POST['words'])) && (isset($_POST['searchedword'])))
{
    $words = $_POST['words'];
    $searchedword = $_POST['searchedword'];
?>
    <tr>
    <td>Word</td>
    <td><?=$searchedword?></td>
    <td>
        <button class='btn btn-danger' type='button' name='DeleteRow'>
            Delete
        </button>
    </td>
<?php
    foreach($words as $word)
    {
        ?>
        <input hidden name="<?=$searchedword?>[]" value="<?=$word?>">
        
<?php
        
    }
   ?>
        </tr>
<?php
}




?>
