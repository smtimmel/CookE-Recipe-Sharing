<?php
//Provides methods for accessing the meal database
require_once('./db_functions.php');

//Retrieves a recipe with the specified id
function meal_by_id($mealID) {
    $query = '
        SELECT * FROM meal 
        WHERE mealID = :mealID';
    $bindStr = array(':mealID');
	$bindVar = array($mealID);
    return single_fetch($query, $bindStr, $bindVar);
}

//Retrieves all meals created by specified account id
function meals_by_accountID($accountID) {
    $query = '
        SELECT * FROM meal 
		JOIN accounts USING (accountID)
        WHERE accounts.accountID = :accountID
		ORDER BY meal.favorited DESC';
    $bindStr = array(':accountID');
	$bindVar = array($accountID);
    return complete_fetch($query, $bindStr, $bindVar);
}

//Retrieves all meals with specified ingredient
function meals_by_ingredient($ingredient) {
    $query = '
        SELECT * FROM meal 
		JOIN components USING (mealID)
        WHERE components.ingredient = :ingredient
		ORDER BY meal.favorited DESC';
    $bindStr = array(':ingredient');
	$bindVar = array($ingredient);
    return complete_fetch($query, $bindStr, $bindVar);
}

//Retrieves all meals created by specified account username
function meals_by_username($username) {
    $query = '
        SELECT * FROM meal 
		JOIN accounts USING (accountID)
        WHERE accounts.username = :username
		ORDER BY meal.favorited DESC';
    $bindStr = array(':username');
	$bindVar = array($username);
    return complete_fetch($query, $bindStr, $bindVar);
}

//Retrieves all meals with the given name
function meals_by_name($name) {
    $query = '
        SELECT * FROM meal 
        WHERE name = :name
		ORDER BY favorited DESC';
    $bindStr = array(':name');
	$bindVar = array($name);
    return complete_fetch($query, $bindStr, $bindVar);
}

//Retrieves all meals favorited by the account with the given id
function meals_by_favorites($accountID) {
	$query = '
        SELECT meal.mealID, meal.name, meal.favorited, meal.accountID FROM meal 
		JOIN interaction USING (mealID)
        WHERE interaction.accountID = :accountID
		AND interaction.favorite = "y"
		ORDER BY meal.favorited DESC';
    $bindStr = array(':accountID');
	$bindVar = array($accountID);
    return complete_fetch($query, $bindStr, $bindVar);
}

//Adds a meal to the database
function add_meal($name, $accountID) {
	$query = 'INSERT INTO meal
		(name, favorited, accountID)
		VALUES
		(:name, 0, :accountID)';
	$bindStr = array(':name', ':accountID');
	$bindVar = array($name, $accountID);
	$link = 'main_page.php';
    no_fetch($query, $bindStr, $bindVar, $link);
	return get_last_id();
}

//Increments the favorite count of the specified meal
function favorite($mealID) {
	$query = 'UPDATE meal SET
		favorited = favorited + 1 
		WHERE mealID = :mealID';
	$bindStr = array(':mealID');
	$bindVar = array($mealID);
	$link = 'main_page.php';
    no_fetch($query, $bindStr, $bindVar, $link);
}

//Deletes all meals created by the specified account
function delete_meals_by_account($accountID) {
	$query = '
        DELETE FROM meal
        WHERE accountID = :accountID';
	$bindStr = array(':accountID');
	$bindVar = array($accountID);
	$link = 'main_page.php';
	no_fetch($query, $bindStr, $bindVar, $link);
}

//Deletes the meal with the given id
function delete_meals_by_id($mealID) {
	$query = '
        DELETE FROM meal
        WHERE mealID = :mealID';
	$bindStr = array(':mealID');
	$bindVar = array($mealID);
	$link = 'main_page.php';
	no_fetch($query, $bindStr, $bindVar, $link);
}