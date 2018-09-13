<?php
if (!isset($_SESSION)) {
	session_start();
}

//functions shared by certain control features
require_once('./account_db.php');
require_once('./component_db.php');
require_once('./step_db.php');
require_once('./interaction_db.php');

//Checks if user request exists, otherwise sets default
function perform_filter($task) {
	$term = filter_input(INPUT_POST, $task);
	if ($term === NULL) {
		$term = filter_input(INPUT_GET, $task);
		if ($term === NULL) {
            $term = 'view';
		}
	}
return $term;
}

//component, account, steps and favorite data added to a meal array
function meal_setup($meals) {
	if (!empty($meals)) {
		foreach($meals as $key => $meal) {
			$meal['username'] = get_username($meal['accountID'])['username'];
			$meal['components'] = get_components($meal['mealID']);
			$meal['steps'] = get_steps($meal['mealID']);
			$meal['isFavorite'] = is_favorited($_SESSION['accountID'], $meal['mealID']);
			$meals[$key] = $meal;
		}
	}
return $meals;
}

//The search choice provided is validated and setup
function choice_validation() {
	$choice = filter_input(INPUT_POST, 'choice', FILTER_SANITIZE_STRING);
	if ($choice === NULL || $choice === '') {
		$error_message = 'Please input a search value';
		$meals = meals_by_accountID($_SESSION['accountID']);
		$meals = meal_setup($meals);
		include 'my_recipe_display.php';
		return false;
	}
	$_SESSION['page'] = 'Search Results: '.$choice;
	$_SESSION['table'] = './recipe_tables.php';
	return $choice;
}
?>