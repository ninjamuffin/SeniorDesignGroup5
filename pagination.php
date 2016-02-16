<?php

class Pagination
{
    
    private function pageInRange($num, $selectedPage, $numPages)
    {
        if ( ($num > 0) && ($num < 5) )
            return true;
        if ( (abs($num - $selectedPage)) < 5 )
            return true;
        if ( (abs($numPages - $selectedPage)) < 5)
            return true;
        return false; 
    }
    public static function getPage($stmt, $pageNum, $rowsPerPage)
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
    
    public static function pageLinks($numOfPages, $pageNum, $rowsPerPage, $rowsReturned, $modulator)
    {
        if($numOfPages <= 1)
            return;
        $firstDivider = false;
        $lastDivider = false;
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
            {
                print("<strong><a href=$pageLink>$frontBound-$endBound</a></strong>&nbsp;&nbsp;");
            }
            elseif( (($j + 1) < $modulator ) || (abs($j + 1 - $pageNum) < $modulator) || (abs($j + 1 - $numPages) < $modulator) || ( ($j + 1) == floor($numOfPages/2)))
                print("<a href=$pageLink>$frontBound-$endBound</a>&nbsp;&nbsp;");
            
            
            
            if( (($j + 1) > ($modulator - 1) && (!($firstDivider)))
            {
                if ($pageNum > (2 * $modulator))
                {
                    print("...&nbsp;&nbsp;");
                    $firstDivider = true;
                }
            }
            if( (($j + 1) > $numOfPages - ($modulator - 1)) && (!($lastDivider)))
            {
                if ( ($numOfPages - $pageNum) >  ($modulator * 2))
                {
                    print("...&nbsp;&nbsp;");
                    $lastDivider = true;
                }
            }

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
    
    
    
    
}