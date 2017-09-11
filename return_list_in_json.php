<?php
/*
* Code to query an SQLite database and return
* results as JSON.
*/
 
// Specify your sqlite database name and path //
$dir = 'sqlite:shopping_list.sqlite';
 
// Instantiate PDO connection object and failure msg //
$dbh = new PDO($dir) or die("cannot open database");
 
// Define your SQL statement //
$query = "SELECT * FROM shopping_list";
 
$out = array();

foreach ($dbh->query($query) as $row) {
	$out[] = $row;
}

echo json_encode($out);
 
?>
