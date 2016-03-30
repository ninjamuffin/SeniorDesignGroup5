<?php
// Array with names

include '../../base.php';


if(!(empty($_POST['keyword']))){
    

    $params = array($_POST['keyword']);
    $options = array( "Scrollable" => 'static' );
    $query ="SELECT Top 4 Language, LanguageID FROM Languages WHERE Language like '" . $_POST["keyword"] . "%' ORDER BY Language";
    $stmt = sqlsrv_query($con, $query, $params, $options);
    if ($stmt === false)
        die(print_r(sqlsrv_errors(), true));
    $languages = [];
    $ids = [];
    while (sqlsrv_fetch($stmt) === true)
    {
        $languages[] = sqlsrv_get_field($stmt, 0);
        $ids[] = sqlsrv_get_field($stmt, 1);
    }
    $length = sqlsrv_num_rows($stmt);

    if(!empty($languages)) {
    ?>
        <ul id="language-list">
        <?php
            for($i = 0; $i < $length; $i++) 
            {
                ?>
                <li onClick="selectLanguage('<?=$languages[$i]?>', '<?=$ids[$i]?>');">
                    <?=$languages[$i]?>
                </li>
                <?php 
            } ?>
        </ul>
    <?php } }
?>
