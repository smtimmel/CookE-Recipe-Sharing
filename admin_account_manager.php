<?php
if (!isset($_SESSION)) {
	session_start();
}
//Ensures user has valid credentials for use
if (!empty($_SESSION) && $_SESSION['admin'] === 'y') { 
require_once('./database.php');
require_once('./account_db.php');
require_once('./interaction_db.php');
require_once('./component_db.php');
require_once('./step_db.php');
require_once('./meal_db.php');
require_once('./control_functions.php');
//Sets up the type of page to be displayed
$_SESSION['page'] = 'Account Manager';
$_SESSION['table'] = 'account_manager_display.php';
$link = 'main_page.php';

//Filters the given user input
$action = perform_filter('action');

switch ($action) {
    case 'view':
		//Provides the management table for the user to view
		$accounts = get_all_accounts();
        include 'other_recipe_display.php';
        break;
    case 'delete':
		//allows user to delete an account
        $accountID = filter_input(INPUT_POST, 'accountID', FILTER_VALIDATE_INT);
		//deletes all database entries corresponding to account
		delete_by_interaction_account($accountID);
		$meals = meals_by_accountID($accountID);
		foreach ($meals as $meal) {
			delete_by_interaction_meal($meal['mealID']);
		}
		delete_components_by_accounts($accountID);
		delete_steps_by_accounts($accountID);
		delete_meals_by_account($accountID);
		delete_account($accountID);
		$accounts = get_all_accounts();
        include 'other_recipe_display.php';
        break;
	case 'admin':
		//Allows the selected account to be made an admin account
		$accountID = filter_input(INPUT_POST, 'accountID', FILTER_VALIDATE_INT);
		make_admin($accountID);
		$accounts = get_all_accounts();
        include 'other_recipe_display.php';
        break;
    default:
		$content = 'ERROR';
        $mes = 'Invalid action request.';
		include 'message.php';
        break;
}
} ?>