<?php

$host = 'o0tvd0xlpb.database.windows.net';
$port = '1433';
$server = $host . ',' . $port;
$database = 'Expression Errors';
$user = 'CS05';
$password = '!1Elcwebapp';

$link = mssql_connect ($server, $user, $password);
if (!$link)
{
	die('ERROR: Could not connect: ' . mssql_get_last_message());
}

mssql_select_db($database);

$query = 'select * from dbo.registration_tbl';

$result = mssql_query($query);
if (!$result) 
{
	$message = 'ERROR: ' . mssql_get_last_message();
	return $message;
}
else
{
	$i = 0;
	echo '<html><body><table><tr>';
	while ($i < mssql_num_fields($result))
	{
		$meta = mssql_fetch_field($result, $i);
		echo '<td>' . $meta->name . '</td>';
		$i = $i + 1;
	}
	echo '</tr>';
	
	while ( ($row = mssql_fetch_row($result))) 
	{
		$count = count($row);
		$y = 0;
		echo '<tr>';
		while ($y < $count)
		{
			$c_row = current($row);
			echo '<td>' . $c_row . '</td>';
			next($row);
			$y = $y + 1;
		}
		echo '</tr>';
	}
	mssql_free_result($result);
	
	echo '</table></body></html>';
}
?>