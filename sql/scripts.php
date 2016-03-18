<?php

/* Table Aliases */
$Aliases = [
    "Teachers" => "T",
    "Students" => "S",
    "Administrators" => "A",
    "SiteUsers" => "SU",
    "RoleInstances" => "RI",
    "Roles" => "R",
    "TeachingInstances" => "TI",
    "Expressions" => "E",
    "Enrollment" => "En",
    "Courses" => "TC",
    "Class Names" => "CN",
    "Worksheets" => "W",
    "Session" => "S", 
    "SessionNames" => "SN",
    "Languages" => "L",
    "Countries" => "C",
];

/* Column Names */
$TeachersColumns = [
    'TeacherID',
    'FirstName', 
    'LastName', 
    'SiteUsername',
    'RoleInstanceID',
    'Email'
];

$StudentsColumns = [
    'StudentID',
    'FirstName',
    'LastName',
    'Email',
    'EmailAlt',
    'RoleInstanceID'  
];
    
$AdministratorsColumns = [
    'AdministratorID',
    'FirstName',
    'LastName',
    'Email',
    'RoleInstanceID'
    
];

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

/* TeacherInfo: Return Array of SELECTed column-values FROM table_list */
function InsertQuery( $target_table, $insert_columns, $insert_values)
{
    $params = array();
    foreach($insert_values as $val)
        $params[] = $val;
    
    $options = array( "Scrollable" => 'static' );
    
    foreach($select_list as $column)
    {
        $
    }
    
    
}

/* Return User Role Information 


*/
function SelectSingular($source_tables, $select_tables, $select_columns, $filter_set)
{
    $params = array($username);
    foreach($filter_set as $filter_var)
        $params[] = $filter_var;
    $options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $statement = "";
}

function SelectMultiple($source_tables, $select_tables, $select_columns, $filter_set)
{
    $params = array($username);
    foreach($filter_set as $filter_var)
        $params[] = $filter_var;
    $options = array( "Scrollable" => 'static' );
    $statement = "";
}
?>

