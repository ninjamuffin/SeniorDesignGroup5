<?php
include_once 'base.php';
function get_expression_query_string($words, $PoS, $offsets)
{
    $num_words = count($words);
    $num_tags = count($PoS);
    $query_length = max($num_words, $num_tags);
    
    $query = "";
    $params = array();
    
    $query .= "SELECT Ex.ExpressionID, Ex.Expression, Ex.[Context/Vocabulary], Ex.Topic_ID FROM Expressions Ex, Dictionary D, SequentialWords SW WHERE Ex.ExpressionID in (SELECT ) ";
    
    for($i = 0; $i < $query_length; $i++)
    {
        $word = $words[$i];
        $tag = $PoS[$i];
        if ( (count($word) == 0 ) && (count($tag) == 0 ) )
            continue;
        if ( count($word) == 0)
        {
            $query .= "D.PoS = ? OR";
            $params .= $tag;
            
        }
    }
    
}

function get_dictionary_entries($words, $tags)
{
    $query = "SELECT WordID, Form, PoS, Frequency FROM Dictionary WHERE ";
    $options = array( "Scrollable" => 'static' );
    $num_words = count($words);
    $num_tags = count($tags);
    $input_length = max($num_words, $num_tags);
    
    $query_length = 0;
    $num_tags = 0;
    $num_words = 0;
    
    for ($i = 0; $i < $input_length; $i++)
    {
        if ( (strlen($words[$i]) > 0) || (strlen($tags[$i]) > 0))
            $query_length++;
        if ( strlen($words[$i]) > 0)
            $num_words++;
        if ( strlen($tags[$i]) > 0)
            $num_tags++;
    }
    $params = array();
    for ($i = 0; $i < $query_length - 1; $i++)
    {
        if ( (strlen($words[$i]) > 0) && (strlen($tags[$i]) > 0))
        {
            $query .= "(Form = ? AND PoS = ?) OR ";
            $params[] = $words[$i];
            $params[] = $tags[$i];
        }
        elseif (strlen($words[$i]) > 0)
        {
            $query .= "(Form = ?) OR ";
            $params[] = $words[$i];
        }
        elseif (strlen($tags[$i]) > 0)
        {
            $query .= "(PoS = ?) OR ";
            $params[] = $tags[$i];
        }
    }
    
    // Last instance
    if ( $query_length > 0 )
    {
        if ( (strlen($words[$query_length - 1]) > 0) && (strlen($tags[$query_length - 1]) > 0))
        {
            $query .= "(Form = ? AND PoS = ?)";
            $params[] = $words[$i];
            $params[] = $tags[$i];
        }
        elseif (strlen($words[$query_length - 1]) > 0)
        {
            $query .= "(Form = ?)";
            $params[] = $words[$i];
        }
        elseif (strlen($tags[$query_length - 1]) > 0)
        {
            $query .="(PoS = ?)";
            $params[] = $tags[$i];
        }
    }
    /*$stmt = sqlsrv_query($con, $query, $params, $options);
    if ($stmt === false)
        die (print_r(sqlsrv_errors(), true));
    $ids = [];
    $forms = [];
    $tags = [];
    $freq = [];
    while (sqlsrv_fetch($stmt) === true)
    {
        $ids = sqlsrv_get_field($stmt, 0);
        $forms = sqlsrv_get_field($stmt, 1);
        $tags = sqlsrv_get_field($stmt, 2);
        $freq = sqlsrv_get_field($stmt, 3);
    }
    $result = array($ids, $forms, $tags, $freq);
    return $result;
    */
    return array($query, $params);
}
?>