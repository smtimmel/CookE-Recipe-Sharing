<?php 
if (!isset($_SESSION)) {
	session_start();
}
//Ensures user is logged in for use
if (!empty($_SESSION)) { 
require_once('./database.php');
require_once('./meal_db.php');
require_once('./component_db.php');
require_once('./step_db.php');
require_once('./account_db.php');
require_once('./interaction_db.php');
require_once('./search_db.php');
require_once('./control_functions.php');

//Validates user request
$search = perform_filter('search');

switch ($search) {
    case 'view':
		//Gets user recipes and prepares form to show credentials to the user
		$meals = meals_by_accountID($_SESSION['accountID']);
		$meals = meal_setup($meals);
        include 'my_recipe_display.php';
        break;
    case 'Recipe':
		//Performs search for recipes by name and prepares results for user
        $choice = choice_validation();
		if ($choice === false) {
			break;
		}
		add_search($search, $choice);
		$meals = meals_by_name($choice);
		$meals = meal_setup($meals);
        include 'other_recipe_display.php';
        break;
	case 'User':
		//Performs search for specific users recipes and prepares results for user
		$choice = choice_validation();
		if ($choice === false) {
			break;
		}
		add_search($search, $choice);
		$meals = meals_by_username($choice);
		$meals = meal_setup($meals);
		include 'other_recipe_display.php';
        break;
	case 'Ingredient':
		//Performs search for recipes with specified ingredients and prepares results for user
		$choice = choice_validation();
		if ($choice === false) {
			break;
		}
		add_search($search, $choice);
		$meals = meals_by_ingredient($choice);
		$meals = meal_setup($meals);
		include 'other_recipe_display.php';
        break;
	case 'delete':
		//Deletes specified recipe
		$mealID = filter_input(INPUT_POST, 'mealID', FILTER_VALIDATE_INT);

		//Deletes all data which has to do with the specified recipe
		delete_by_interaction_meal($mealID);
		delete_components_by_meals($mealID);
		delete_steps_by_meals($mealID);
		delete_meals_by_id($mealID);
		$link = 'main_page.php';
		$content = 'SUCCESS';
		$mes = 'Meal deletion successful!';
		include 'message.php';
		break;
    default:
		$link = 'index.php';
		$content = 'ERROR';
        $mes = 'Invalid request.';
		include 'message.php';
        break;
}
} ?>