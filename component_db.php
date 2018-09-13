<?php
//Provides database methods for component database, uses db_functions as a template
require_once('./db_functions.php');

//Adds a component entry to the database with user inputs
function add_component($mealID, $ingredient, $quantity, $unit) {
	$query = 'INSERT INTO components
		(ingredient, quantity, unit, mealID)
		VALUES
		(:ingredient, :quantity, :unit, :mealID)';
	$bindStr = array(':ingredient', ':quantity', ':unit', ':mealID');
	$bindVar = array($ingredient, $quantity, $unit, $mealID);
	$link = 'main_page.php';
	no_fetch($query, $bindStr, $bindVar, $link); 
}

//Retrieves all components corresponding to the given meal id
function get_components($mealID) {
    $query = '
        SELECT ingredient, quantity, unit FROM components 
        WHERE mealID = :mealID';
    $bindStr = array(':mealID');
	$bindVar = array($mealID);
	return complete_fetch($query, $bindStr, $bindVar);
}

//Deletes all components owned by the specified account
function delete_components_by_accounts($accountID) {
	$query = '
        DELETE components FROM components 
		JOIN meal USING (mealID)
        WHERE meal.accountID = :accountID';
	$bindStr = array(':accountID');
	$bindVar = array($accountID);
	$link = 'main_page.php';
	no_fetch($query, $bindStr, $bindVar, $link); 
}

//deletes all components owned by specified meal
function delete_components_by_meals($mealID) {
	$query = '
        DELETE FROM components 
        WHERE mealID = :mealID';
	$bindStr = array(':mealID');
	$bindVar = array($mealID);
	$link = 'main_page.php';
	no_fetch($query, $bindStr, $bindVar, $link); 
}