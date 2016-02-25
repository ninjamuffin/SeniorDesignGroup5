<?php

function getArray_POST($Post_Array)
{
    $return_array = array();
    if (!empty($_POST[$Post_Array]))
    {
        foreach($_POST[$Post_Array] as $element)
            $return_array[] = $element;
    }
    else
        return false;
    return $return_array;
}
?>