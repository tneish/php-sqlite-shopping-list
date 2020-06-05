<?php
    // history
	// 1.0: original, change hidden and order
	// 2.0: add lastused time for greying out old entries

	$postinput = substr($_POST["data"], 0, -1);  // chop last delimeter off

	if (strlen($postinput) < 1) {
		exit();
	}

	$dbitems = explode(";", $postinput);

	// Specify your sqlite database name and path //
	$dir = 'sqlite:shopping_list.sqlite';
 
	// Instantiate PDO connection object and failure msg //
	$dbh = new PDO($dir) or die("cannot open database");
	$dbh->exec("pragma synchronous = off;");  // speeeeed
	$dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	
	$sql_update = 
	'UPDATE `shopping_list`   
	 SET `order` = :order,
	      `hidden` = :hidden,
		  `lastused` = :lastused
	 WHERE `id` = :id';
	$q_update = $dbh->prepare($sql_update);

	$sql_delete =
	'DELETE FROM `sl`
	 WHERE `id` = :id';
	$q_delete = $dbh->prepare($sql_delete);
	

	$sql_insert = 'INSERT INTO `sl` (`description`, `shop`) VALUES (:description, :shop)';
	$q_insert = $dbh->prepare($sql_insert);		
	
	// '2017-03-25' 
	$lastusedStringNow = date('Y-m-d');  // today's date to be stored. Matches javascript ISO format
	
	// iterate dbitems
	foreach ($dbitems as $dbitem) {
		$itemInfo = json_decode($dbitem, true);
		if (array_key_exists('removeid', $itemInfo)) {
			// Remove
			try {
				$remove_id = (string)$itemInfo['removeid'];
				$q_delete->bindParam(":id", $remove_id);
				$q_delete->execute();

			} catch (PDOException $e) {
				var_dump($e);
			}
		} else {  // new item 
			try {
				//var_dump($itemInfo);
				$q_insert->bindParam(":description", $itemInfo['description']);
				$q_insert->bindParam(":shop", $itemInfo['shop']);
				$q_insert->execute();
			} catch (PDOException $e) {
				var_dump($e);
			}

		}
	}

?>