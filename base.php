<?php
     //This is the php file that will track our user session info.  Needed for login and logout.
     session_start();
     
     $dbhost = "o0tvd0xlpb.database.windows.net,1433"; //the name of the server
     $dbname = "Smalltalk Migrate 2.0"; //name of the database
     $dbuser = "CS05"; //the database username
     $dbpass = "!1Elcwebapp"; //db user password
     
     sqlsrv_connect($dbhost, $dbuser, $dbpass) or die(print_r( sqlsrv_errors(), true));
?>