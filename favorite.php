<?php if (!isset($_SESSION)) {
	session_start();
}
//Ensures user is logged in
if (!empty($_SESSION)) { 
require_once('./database.php');
require_once('./meal_db.php');
require_once('./interaction_db.php');
require_once('./control_functions.php');

//Checks user request
$action = perform_filter('action');

//Page to be displayed setup
$_SESSION['page'] = 'My Favorites';
$_SESSION['table'] = './recipe_tables.php';

switch ($action) {
    case 'view':
		//Recipes to be displayed setup
		$meals = meals_by_favorites($_SESSION['accountID']);
		$meals = meal_setup($meals);
        include 'other_recipe_display.php';
        break;
    case 'add':
		//Adds a favorite for the user
		$mealID = filter_input(INPUT_POST, 'mealID', FILTER_VALIDATE_INT);

		//increments meal favorite account
        favorite($mealID);

		//creates interaction between account and meal
		add_interaction($_SESSION['accountID'], $mealID, 'y');
		$link = 'favorite.php';
		$content = 'SUCCESS';
		$mes = 'Recipe favorited!';
		include 'message.php';
        break;
    default:
		$link = 'index.php';
		$content = 'ERROR';
        $mes = 'Invalid action request.';
		include 'message.php';
        break;
}
} ?>