<?php
//functions for accessing interaction database table
require_once('./db_functions.php');

//Checks if meal has been favorited by the user
function is_favorited($accountID, $mealID) {
    $query = '
        SELECT favorite FROM interaction 
        WHERE accountID = :accountID AND mealID = :mealID';
    $bindStr = array(':accountID', ':mealID');
	$bindVar = array($accountID, $mealID);
    $meals = single_fetch($query, $bindStr, $bindVar);
    if (empty($meals) || $meals === 'n') {
		return false;
	}
	return true;
}

//Creates an interaction using given arguments
function add_interaction($accountID, $mealID, $favorite) {
	$query = 'INSERT INTO interaction
		(accountID, mealID, favorite)
		VALUES
		(:accountID, :mealID, :favorite)';
	$bindStr = array(':accountID', ':mealID', 'favorite');
	$bindVar = array($accountID, $mealID, $favorite);
	$link = 'main_page.php';
    no_fetch($query, $bindStr, $bindVar, $link);
}

//Deletes interactions with the given account id
function delete_by_interaction_account($accountID) {
	$query = '
		DELETE FROM interaction
		WHERE accountID = :accountID';
	$bindStr = array(':accountID');
	$bindVar = array($accountID);
	$link = 'main_page.php';
	no_fetch($query, $bindStr, $bindVar, $link);
}

//deletes interactions with the given meal id
function delete_by_interaction_meal($mealID) {
	$query = '
		DELETE FROM interaction
		WHERE mealID = :mealID';
	$bindStr = array(':mealID');
	$bindVar = array($mealID);
	$link = 'main_page.php';
	no_fetch($query, $bindStr, $bindVar, $link);
}