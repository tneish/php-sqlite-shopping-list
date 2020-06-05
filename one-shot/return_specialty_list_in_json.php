<?php
/*
* Code to query an SQLite database and return
* results as JSON.
*/
 
// Specify your sqlite database name and path //
$dir = 'sqlite:shopping_list.sqlite';
 

// Instantiate PDO connection object and failure msg //
$dbh = new PDO($dir) or die("cannot open database");

$out = array();

try {
	$stmt = $dbh->prepare("SELECT * FROM sl ORDER BY shop");
	$stmt->execute();

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$out[] = $row;
	}

	$stmt = null;

} catch (PDOException $e) {
	die($e->getMessage());
}

echo json_encode($out);

 
?>
