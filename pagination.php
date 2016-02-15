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

function pageLinks($numPages, $pageNum, $rowsPerPage)
{
    if($pageNum > 1)
    {
        $prevPageLink = "?pageNum=".($pageNum - 1);
        echo "<a href='$prevPageLink'>Previous Page</a>&nbsp;&nbsp;";
    }
    $num = 1;
    $firstPageLink = "?pageNum=$num";
    print("<a href=$firstPageLink>1-($rowsPerPage-1)</a>&nbsp;&nbsp;");
    if($numOfPages < 20)
    {
        for($i = 2; $i <=$numOfPages; $i++)
        {
            $pageLink = "?pageNum=$i";
            print("<a href=$pageLink>$i</a>&nbsp;&nbsp;");
        }   
    }
    else
    {
        for($i = 10; $i <$numOfPages; $i+= 10)
        {
            $pageLink = "?pageNum=$i";
            print("<a href=$pageLink>$i</a>&nbsp;&nbsp;");
        }
        $pageLink = "?pageNum=$numOfPages";
        print("<a href=$pageLink>$numOfPages</a>&nbsp;&nbsp;");
    }
    // Display Next Page link if applicable.
    if($pageNum < $numOfPages)
    {
        $nextPageLink = "?pageNum=".($pageNum + 1);
        echo "&nbsp;&nbsp;<a href='$nextPageLink'>Next Page</a>";
    }
    
}