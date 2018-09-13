<?php
//General functions for accessing a database

//Checks if query produces any rows
function check_if_rows($query, $bindStr, $bindVar) {
    global $db;
    $statement = $db->prepare($query);
	for ($i = 0; $i < count($bindStr); $i++) {
		$statement->bindValue($bindStr[$i], $bindVar[$i]);
	}
    $statement->execute();
    if ($statement->rowCount() != 0) {
        $valid = true;
    } else {
        $valid = false;
    }
    $statement->closeCursor();
    return $valid;
}

//Provides fetch of a single record
function single_fetch($query, $bindStr, $bindVar) {
    global $db;
    $statement = $db->prepare($query);
	for ($i = 0; $i < count($bindStr); $i++) {
		$statement->bindValue($bindStr[$i], $bindVar[$i]);
	}
    $statement->execute();
	$result = $statement->fetch();
	$statement->closeCursor();
    return $result;
}

//Executes statements which do not yield query results
function no_fetch($query, $bindStr, $bindVar, $link) {
	global $db;
	try {
        $statement = $db->prepare($query);
		for ($i = 0; $i < count($bindStr); $i++) {
			$statement->bindValue($bindStr[$i], $bindVar[$i]);
		}
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
		$content = 'ERROR';
        $mes = $e->getMessage();
        include 'message.php';
		exit();
    }
}

//Provides fetch of all query results
function complete_fetch($query, $bindStr, $bindVar) {
	global $db;
    $statement = $db->prepare($query);
	for ($i = 0; $i < count($bindStr); $i++) {
		$statement->bindValue($bindStr[$i], $bindVar[$i]);
	}
	$statement->execute();
    $meals = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
	return $meals;
}

//Gets last id put into database
function get_last_id() {
	global $db;
	return $db->lastInsertId();
}

?>