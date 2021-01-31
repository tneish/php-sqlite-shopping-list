<?php
    // history
	// 1.0: original, change hidden and order
	// 2.0: add lastused time for greying out old entries
	// 3.0: add support for delete items
	
	$dbitems = explode(";", substr($_POST["data"], 0, -1));  // chop last delimeter off


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
	$sql_insert = 'INSERT INTO `shopping_list` (`order`, `hidden`, `description`, `lastused`) VALUES (:order, :hidden,:description,:lastused)';
	$q_insert = $dbh->prepare($sql_insert);		

	$sql_delete = 'DELETE FROM `shopping_list` WHERE `id` = :id';
	$q_delete = $dbh->prepare($sql_delete);

	// '2017-03-25' 
	$lastusedStringNow = date('Y-m-d');  // today's date to be stored. Matches javascript ISO format
	
	// iterate dbitems
	foreach ($dbitems as $dbitem) {
		$itemInfo = json_decode($dbitem, true);
		if (array_key_exists('id', $itemInfo)) {
			// id present, check if delete or update
			if (array_key_exists('deleteflag', $itemInfo)) {
				// delete item
				try {
					//var_dump($itemInfo);
					$b = array($itemInfo['id']);
					$b[0] = (string)$b[0];
					$q_delete->bindParam(":id", $b[0]);
					$q_delete->execute();
				} catch (PDOException $e) {
					var_dump($e);
				}
			
			} else {
				// update hidden
				try {
					//var_dump($itemInfo);
					$b = array($itemInfo['hidden'],$itemInfo['order'],$itemInfo['id'],$itemInfo['lastused']);
					$b[0] = (string)$b[0];
					$b[1] = (string)$b[1];
					$q_update->bindParam(":order", $b[1]);
					$q_update->bindParam(":hidden", $b[0]);
					if ($b[0] == '0') { // item is checked, update last used date to now
						$q_update->bindParam(":lastused", $lastusedStringNow);
					} else {
						$q_update->bindParam(":lastused", $b[3]);  // keep previous date
					}
					$q_update->bindParam(":id", $b[2]);
	
					$q_update->execute();
				} catch (PDOException $e) {
					var_dump($e);
				}
			}

		} else {  // new item 
			try {
				//var_dump($itemInfo);
				$b = array($itemInfo['hidden'],$itemInfo['description'],$itemInfo['order']);
				$b[0] = (string)$b[0];
				$b[2] = (string)$b[2];
				$q_insert->bindParam(":hidden", $b[0]);
				$q_insert->bindParam(":description", $b[1]);
				$q_insert->bindParam(":order", $b[2]);
				$q_insert->bindParam(":lastused", $lastusedStringNow);
				$q_insert->execute();
			} catch (PDOException $e) {
				var_dump($e);
			}

		}
	}

?>
