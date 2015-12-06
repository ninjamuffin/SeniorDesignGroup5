<?php
$myServer = "o0tvd0xlpb.database.windows.net";
$myUser = "CS05";
$myPass = "!1Elcwebapp";
$myDB = "Expression Errors"; 

//create an instance of the  ADO connection object
$conn = new COM ("ADODB.Connection")
  or die("Cannot start ADO");

//define connection string, specify database driver
$connStr = "PROVIDER=SQLOLEDB;SERVER=".$myServer.";UID=".$myUser.";PWD=".$myPass.";DATABASE=".$myDB; 
  $conn->open($connStr); //Open the connection to the database

//declare the SQL statement that will query the database
$query = "SELECT * FROM dbo.registration_tbl";

//execute the SQL statement and return records
$rs = $conn->execute($query);

$num_columns = $rs->Fields->Count();
echo $num_columns . "<br>";  

for ($i=0; $i < $num_columns; $i++) {
    $fld[$i] = $rs->Fields($i);
}

echo "<table>";
while (!$rs->EOF)  //carry on looping through while there are records
{
    echo "<tr>";
    for ($i=0; $i < $num_columns; $i++) {
        echo "<td>" . $fld[$i]->value . "</td>";
    }
    echo "</tr>";
    $rs->MoveNext(); //move on to the next record
}


echo "</table>";

//close the connection and recordset objects freeing up resources 
$rs->Close();
$conn->Close();

$rs = null;
$conn = null;
?>