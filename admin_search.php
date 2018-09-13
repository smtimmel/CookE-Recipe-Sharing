<?php if (!isset($_SESSION)) {
	session_start();
}
//Ensures user has credentials for use
if (!empty($_SESSION) && $_SESSION['admin'] === 'y') { 
require_once('./database.php');
require_once('./search_db.php');

//Prepares search table for display
$searches = get_search();
$_SESSION['page'] = 'Search Data';
$_SESSION['table'] = 'admin_search_display.php';

include 'other_recipe_display.php';
} ?>