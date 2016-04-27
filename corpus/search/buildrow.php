<?php
// Array with names

include '../../base.php';

if ((isset($_POST['words'])) && (isset($_POST['searchedword'])))
{
    $words = $_POST['words'];
    $num_words = count($words);

    $searchedword = $_POST['searchedword'];
?>
    <tr>
    <td>Word</td>
    <td>
    <input hidden type="text" name="search_words[]" value="<?=$searchedword?>">
<?php
    foreach($words as $word)
    {
?>
        <input hidden type="text" name="<?=$searchedword?>[]" value="<?=$word?>">
<?php
    }

    echo $word;
?>
    </td>
    <td>
        <button class='btn btn-danger' type='button' name='DeleteRow'>
            Delete
        </button>
    </td>
<?php
    foreach($words as $word)
    {
        ?>
        <p><?=$word?></p>
        
        
<?php
        
    }
   ?>
        </tr>
<?php
}




?>
