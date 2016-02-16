<?php


function getPage($stmt, $pageNum, $rowsPerPage)
{
    $offset = ($pageNum - 1) * $rowsPerPage;
    $rows = array();
    $i = 0;
    while(($row = sqlsrv_fetch_array($stmt, 
                                    SQLSRV_FETCH_NUMERIC,
                                    SQLSRV_SCROLL_ABSOLUTE,
                                    $offset + $i))
          && $i < $rowsPerPage)
    {
        array_push($rows, $row);
        $i++;
    }
    return $rows;
    
}

function pageLinks($numOfPages, $pageNum, $rowsPerPage, $rowsReturned)
{
    if($numOfPages <= 1)
        return;
    if($pageNum > 1)
    {
        $prevPageLink = "?pageNum=".($pageNum - 1)."&pp=$rowsPerPage";
        echo "<a href='$prevPageLink'>Previous Page</a>&nbsp;&nbsp;";
    }
    for($j = 0; $j < $numOfPages - 1; $j++)
    {
        $frontBound = ($j * $rowsPerPage) + 1;
        $endBound = ($j + 1) * $rowsPerPage;
        $linkedPageNum = $j + 1;
        $pageLink = "?pageNum=$linkedPageNum&pp=$rowsPerPage";
        if ( ($j + 1) == $pageNum)
            print("<strong><a href=$pageLink>$frontBound-$endBound</a></strong>&nbsp;&nbsp;");
        elseif( ( ($j + 1 - $pageNum) > -5) && ($j + 1 - $pageNum) < 5)
            print("<a href=$pageLink>$frontBound-$endBound</a>&nbsp;&nbsp;");
            
    }
    
    /* Print Last Page Link (endpoint = last row) */
    $pageLink = "?pageNum=$numOfPages&pp=$rowsPerPage";
    $frontBound = (($numOfPages - 1) * $rowsPerPage) + 1;
    $endBound = $rowsReturned;
    if($pageNum == $numOfPages)
        print("<strong><a href=$pageLink>$frontBound-$rowsReturned</a></strong>&nbsp;&nbsp;");
    else
        print("<a href=$pageLink>$frontBound-$rowsReturned</a>&nbsp;&nbsp;");
    
    // Display Next Page link if applicable.
    if($pageNum < $numOfPages)
    {
        $nextPageLink = "?pageNum=".($pageNum + 1)."&pp=$rowsPerPage";
        echo "&nbsp;&nbsp;<a href='$nextPageLink'>Next Page</a>";
    }
    
}