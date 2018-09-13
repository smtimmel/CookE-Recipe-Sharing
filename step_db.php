<?php
//Provides functions for accessing step database table
require_once('./db_functions.php');

//Adds a step to the database with given arguments
function add_step($stepNum, $description, $mealID) {
	$query = 'INSERT INTO step
		(stepNum, description, mealID)
		VALUES
		(:stepNum, :description, :mealID)';
	$bindStr = array(':stepNum', ':description', ':mealID');
	$bindVar = array($stepNum, $description, $mealID);
	$link = 'main_page.php';
    no_fetch($query, $bindStr, $bindVar, $link);
}

//Gets all steps in the database that correspond to given recipe
function get_steps($mealID) {
    $query = '
        SELECT stepNum, description FROM step
        WHERE mealID = :mealID';
    $bindStr = array(':mealID');
	$bindVar = array($mealID);
	return complete_fetch($query, $bindStr, $bindVar);
}

//deletes steps from the recipes created by the specified user
function delete_steps_by_accounts($accountID) {
	$query = '
        DELETE step FROM step
		JOIN meal USING (mealID)
        WHERE meal.accountID = :accountID';
	$bindStr = array(':accountID');
	$bindVar = array($accountID);
	$link = 'main_page.php';
	no_fetch($query, $bindStr, $bindVar, $link);
}

//deletes steps from the recipes with given id
function delete_steps_by_meals($mealID) {
	$query = '
        DELETE FROM step
        WHERE mealID = :mealID';
	$bindStr = array(':mealID');
	$bindVar = array($mealID);
	$link = 'main_page.php';
	no_fetch($query, $bindStr, $bindVar, $link);
}